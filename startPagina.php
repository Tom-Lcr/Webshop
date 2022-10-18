<?php
//startPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();

use Business\ArtikelService;
use Entities\Artikel;
//use Entities\Winkelkar;

//Hieronder roep ik eerst een lijst van alle artikelen aan

$artikelSvc = new ArtikelService();
$artikelLijst = $artikelSvc->getOverzicht();

foreach ($artikelLijst as $artikel) {
    //Hieronder ga ik voor elk artikel het artikelId gaan halen
               print($artikelId = $artikel->getArtikelId());
               print($score = $artikelSvc->getRating($artikelId)); //voor elk artikelId wordt in de database gezocht naar een score
               //Op basis van de scores zou dan eventueel gerangschikt kunnen worden in de presentation
            }



include("presentation/startPagina.php");	

?>
