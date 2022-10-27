<?php

//startPagina.php
declare(strict_types = 1);

spl_autoload_register();

session_start();

use Data\ActieCodeDAO;
use Data\ArtikelDAO;
use Entities\Opties;
use Entities\Actiecode;

print_r((new ActieCodeDAO())->controleerActiecode("Halloween"));







//$opties = new Opties;

//print($opties->getQuery());
//$artikelen = (new ArtikelDAO())->getArtikels($opties);
//print_r($artikelen);