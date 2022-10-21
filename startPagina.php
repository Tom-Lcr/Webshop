<?php
//startPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();

/*Tom: Hieronder is een lijst gegenereerd van de artikelen door islam met een functie van mij erin 
om de rating toe te voegen daaronder ook een foreach om artikel objecten te genereren voor moesten we
die nodig hebben.*/

use Business\ArtikelService;
use Business\CategorieService;
use Business\WinkelkarService;
use Entities\Artikel;
//Tom: use Entities\Winkelkar; Kan uit commentaar wanneer we de winkelkar nodig hebben


$artikelSvc = new ArtikelService();
if (!isset($_SESSION["filter"])) {
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



$aantalArtikelsPerPagina = 20;
if ($_SESSION["filter"] = "default") {
   $aantalRijen = $artikelSvc->getAantalArtikelRijen();
   $aantalPaginas = ceil($aantalRijen / $aantalArtikelsPerPagina);
}

if (isset($_GET["action"]) && $_GET["action"] == "zoek") {
    $_SESSION["filter"] = "zoek"; 
    $aantalRijen = $artikelSvc->getAantalZoekArtikelRijen($_POST["search"]);
    $aantalPaginas = ceil($aantalRijen / $aantalArtikelsPerPagina);
}

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

if (isset($_GET["action"]) && $_GET["action"] == "filter") {
     $artikelSvc->getArtikelOverzicht((int) $pagina, (int) $aantalArtikelsPerPagina, $_POST["sorteerOpties"]);
}    
 
if ($_SESSION["filter"] = "default") {
   $artikelLijst = $artikelSvc->getArtikelOverzicht((int) $pagina, (int) $aantalArtikelsPerPagina);    
}             

if ($_SESSION["filter"] = "zoek" && isset($_POST["search"])) {
   
   $artikelLijst = $artikelSvc->zoekArtikelen($_POST["search"], (int) $pagina, (int) $aantalArtikelsPerPagina);
}





include("Presentation/startPagina.php");
