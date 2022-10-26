<?php
//bestellingOverzichtPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();


use Business\BestellingService;
use Business\ArtikelService;
use Entities\Gebruiker;

//$gebruiker = unserialize($_SESSION["gebruiker"]);
$bestellingSvc = new BestellingService();
$bestellingLijst = $bestellingSvc->getBestellingOverzicht(1);//($gebruiker->getKlantId());

foreach($bestellingLijst as $bestelling) {
    $bestellijnen = $bestelling->getBestellijnen();
}

$artikelSvc = new ArtikelService;

  
include("Presentation/bestellingOverzichtPagina.php");