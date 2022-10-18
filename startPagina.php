<?php
//startPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();

//Ik wist voor de controller uiteraard nog niet wat we hier exact gaan nodig hebben
//dus ik heb een lijst gegenereerd van de artikelen en ook een mogelijkheid van om van elk
//artikel de score te weten te komen.

use Business\ArtikelService;
use Entities\Artikel;
//use Entities\Winkelkar; Kan uit commentaar wanneer we de winkelkar nodig hebben

//Hieronder roep ik eerst een lijst van alle artikelen aan

$artikelSvc = new ArtikelService();
$artikelLijst = $artikelSvc->getOverzicht();

foreach ($artikelLijst as $artikel) { //elk $artikel = een object $artikel
    //Hieronder ga ik voor elk artikel het artikelId gaan halen
               $artikelId = $artikel->getArtikelId();
               $score = $artikelSvc->getRating($artikelId);
               //voor elk artikelId wordt in de database gezocht naar een score
               //indien score onbestaande is wordt een 0 terug gegeven
               //Op basis van de scores die eruit gehaald worden zou dan eventueel gerangschikt kunnen worden in de presentation
            }



include("presentation/startPagina.php");	

?>
