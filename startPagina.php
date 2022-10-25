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



$aantalArtikelsPerPagina = 20;

if (isset($_GET["action"]) && $_GET["action"] == "zoek") {
    unset($_SESSION["sorteerOptie"]);
    $_SESSION["filter"] = "zoek"; 
    $_SESSION["zoekterm"] = $_POST["search"];
}

if (isset($_GET["action"]) && $_GET["action"] == "filter") {
    unset($_SESSION["zoekterm"]);
     $_SESSION["filter"] = "sorteerOpties";
     $_SESSION["sorteerOptie"] = $_POST["sorteerOpties"];
}

if ($_SESSION["filter"] == "default" || $_SESSION["filter"] == "sorteerOpties") {
   $aantalRijen = $artikelSvc->getAantalArtikelRijen();
   $aantalPaginas = ceil($aantalRijen / $aantalArtikelsPerPagina);
}

if(isset($_SESSION["zoekterm"])) {
    $aantalRijen = $artikelSvc->getAantalZoekArtikelRijen($_SESSION["zoekterm"]);
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

if ($_SESSION["filter"] == "default") {
   $artikelLijst = $artikelSvc->getArtikelOverzicht((int) $pagina, (int) $aantalArtikelsPerPagina, "rating DESC, prijs DESC");    
}  

if(isset($_SESSION["sorteerOptie"])) {
    $artikelLijst = $artikelSvc->getArtikelOverzicht((int) $pagina, (int) $aantalArtikelsPerPagina, $_SESSION["sorteerOptie"]);
}

if (isset($_SESSION["zoekterm"])) {
    $artikelLijst = $artikelSvc->zoekArtikelen($_SESSION["zoekterm"], (int) $pagina, (int) $aantalArtikelsPerPagina);
}




  

  
include("Presentation/startPagina.php");
