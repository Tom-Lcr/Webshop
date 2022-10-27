<?php
//startPagina.php
declare(strict_types=1);

spl_autoload_register();

session_start();

/*Tom: Hieronder is een lijst gegenereerd van de artikelen door islam met een functie van mij erin 
om de rating toe te voegen daaronder ook een foreach om artikel objecten te genereren voor moesten we
die nodig hebben.*/

use Data\ArtikelDAO;
use Business\ArtikelService;
use Business\CategorieService;
use Business\WinkelkarService;
use Entities\Artikel;
use Entities\Opties;
//Tom: use Entities\Winkelkar; Kan uit commentaar wanneer we de winkelkar nodig hebben


$artikelSvc = new ArtikelService();
if (!isset($filter)) {
$_SESSION["filter"] = "default";
}
$error = "";
if (!isset($_SESSION["aantalitems"])){
    $_SESSION["aantalitems"] = 0;
}
if (isset($_GET["action"]) && $_GET["action"] == "voegToe") {
    $gekozenArtikel = $artikelSvc->getArtikelById((int)$_GET["id"]);
    if ($gekozenArtikel->getVoorraad() >= 1) {
    $winkelkarSvc = new WinkelkarService();
    $winkelkarArtikel = $winkelkarSvc->voegItemToe((int)$_GET["id"], (int)$_POST["aantalVanArtikel"]);
    $_SESSION["aantalitems"] += $winkelkarArtikel->getAantal();
    $_SESSION["winkelmand"][] = serialize($winkelkarArtikel);
    }else{
        $error = "Dit product is niet in voorraad";
    }
}



$opties;
if (isset($_SESSION["opties"])) {
    $opties = unserialize($_SESSION["opties"]);
} else {
    $opties = new Opties();
    //print_r($opties);
}

if (isset($_GET["action"]) && $_GET["action"] === "zoek") {
    $opties->setZoekterm($_POST["search"]);
}

if (isset($_GET["categorie"])) {
    $opties->setCategorie((int) $_GET["categorie"]);
}

if (isset($_GET["action"]) && $_GET["action"] === "filter") {
    $opties->setVolgorde((int) $_POST["sorteerOpties"]);

    $opties->setEnkelBeschikbaar(in_array("nuBeschikbaar", $_POST['checkboxen'] ?? []));
    $opties->setMetRecentie(in_array("metRecensie", $_POST['checkboxen'] ?? []));
    $opties->setZonderRecentie(in_array("zonderRecensie", $_POST['checkboxen'] ?? []));
    $opties->controleerRecenties();
}

if (isset($_GET["action"]) && $_GET["action"] === "reset") {
    $opties = new Opties();
}

$_SESSION["opties"] = serialize($opties);

$error = "";
if (!isset($_SESSION["aantalitems"])) {
    $_SESSION["aantalitems"] = 0;
}
if (isset($_GET["action"]) && $_GET["action"] == "voegToe") {
    $gekozenArtikel = $artikelSvc->getArtikelById((int)$_GET["id"]);
    if ($gekozenArtikel->getVoorraad() >= 1) {
        $winkelkarSvc = new WinkelkarService();
        $winkelkarArtikel = $winkelkarSvc->voegItemToe((int)$_GET["id"], (int)$_POST["aantalVanArtikel"]);
        $_SESSION["aantalitems"] += $winkelkarArtikel->getAantal();
        $_SESSION["winkelmand"][] = serialize($winkelkarArtikel);
    } else {
        $error = "Dit product is niet in voorraad";
    }
}

$aantalArtikelsPerPagina = 20;
$aantalArtikels = (new ArtikelService())->getAantalArtikels($opties);
$aantalPaginas = ceil($aantalArtikels / $aantalArtikelsPerPagina);

if (isset($_GET["page"])) {
    $pagina = $_GET["page"];
    if ($pagina < 1) {
        $pagina = 1;
    } else if ($pagina > $aantalPaginas) {
        $pagina = $aantalPaginas;
    }
} else {
    $pagina = 1;
}

$catSvc = new CategorieService();
//print("categorie: ");
//print($opties->getCategorie());
//print(" |");

$categorie2 = $catSvc->getCategorieById((int) $opties->getCategorie());
$categorieen =  $catSvc->getSubcategorieenById($opties->getCategorie());
$artikelLijst = (new ArtikelService())->getArtikelLijst($opties, (int) $pagina, (int) $aantalArtikelsPerPagina);


//print_r("categorie: " . $categorie->getNaam() ?? "niks");
//print($opties->getQuery() . "<br><br>");
include("Presentation/startPagina.php");
