<?php
//startPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();

/*Tom: Ik wist voor de controller uiteraard nog niet wat we hier exact gaan nodig hebben
dus er is een lijst gegenereerd van de artikelen door islam en ook een mogelijkheid van om van elk
artikel de score te weten te komen eventueel om ze te rangschikken onderaan, vandaar de foreach.*/

use Business\ArtikelService;
use Entities\Artikel;
//Tom: use Entities\Winkelkar; Kan uit commentaar wanneer we de winkelkar nodig hebben


$artikelSvc = new ArtikelService();
$error = "";
if (isset($_GET["action"]) && $_GET["action"] == "voegToe") {
    $gekozenArtikel = $artikelSvc->getArtikelById((int)$_GET["id"]);
    if ($gekozenArtikel->getVoorraad() >= 1) {
    $winkelkarSvc = new WinkelkarService();
    $winkelkarArtikel = $winkelkarSvc->voegItemToe((int)$_GET["id"], (int)$_POST["aantalVanArtikel"]);
    $_SESSION["winkelmand"][] = serialize($winkelkarArtikel);
    }else{
        $error = "Dit product is niet in voorraad";
    }
}
$aantalArtikelsPerPagina = 20;
$aantalRijen = $artikelSvc->getAantalArtikelRijen();
$aantalPaginas = ceil($aantalRijen / $aantalArtikelsPerPagina);
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
$eerstePaginaArtikel = ($pagina-1)*$aantalArtikelsPerPagina;
$artikelLijst = $artikelSvc->getArtikelOverzicht((int) $eerstePaginaArtikel, (int) $aantalArtikelsPerPagina);

foreach ($artikelLijst as $artikel) { //elk $artikel = een object $artikel
    //Hieronder ga ik voor elk artikel het artikelId gaan halen
               $artikelId = $artikel->getArtikelId();
               $rating = $artikelSvc->getRating($artikelId);
               //voor elk artikelId wordt in de database gezocht naar een score
               //indien score onbestaande is wordt een 0 terug gegeven
               //Op basis van de scores die eruit gehaald worden zou dan eventueel gerangschikt kunnen worden in de presentation
            }

include("Presentation/startPagina.php");
