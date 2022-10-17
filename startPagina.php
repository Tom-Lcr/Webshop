<?php
//startPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();

use Business\ArtikelService;
use Entities\Artikel;
use Entities\Winkelkar;

$artikelSvc = new ArtikelService();
$artikelLijst = $artikelSvc->getOverzicht();


include("presentation/startPagina.php");	


