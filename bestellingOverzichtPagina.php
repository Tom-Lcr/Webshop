<?php
//bestellingOverzichtPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();


use Business\BestellingService;
use Entities\Gebruiker;

$gebruiker = unserialize($_SESSION["gebruiker"]);
$bestellingSvc = new BestellingService();
$bestellingen = $bestellingSvc->getBestellingOverzicht($gebruiker->getKlantId());
  

  
include("Presentation/bestellingOverzichtPagina.php");