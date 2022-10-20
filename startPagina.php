<?php
//startPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();

/*Tom: Hieronder is een lijst gegenereerd van de artikelen door islam met een functie van mij erin 
om de rating toe te voegen daaronder ook een foreach om artikel objecten te genereren voor moesten we
die nodig hebben.*/

use Business\ArtikelService;
use Entities\Artikel;
//Tom: use Entities\Winkelkar; Kan uit commentaar wanneer we de winkelkar nodig hebben


$artikelSvc = new ArtikelService();

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

foreach ($artikelLijst as $artikel) { // Tom: objecten artikel hebben we mogelijk nodig
           

}

/*test veriable winkelkar badge*/

if (!isset($_SESSION["aantalTeller"])){
    $_SESSION["aantalTeller"] = 0;
}

if(isset($_POST["btnWinkelKar"]) && isset($_POST["aantalVanArtikel"])){
    /* hier komt de code om het huidig aantal artikelen die in de winkelkar zitten te berekenen 
    en aan te duiden via de winkelkar badge */

    /*test sessie variabele*/
    $_SESSION["aantalTeller"] += (int) $_POST["aantalVanArtikel"];
}

include("Presentation/startPagina.php");
