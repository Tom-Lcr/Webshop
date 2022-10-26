<?php

declare(strict_types=1);

spl_autoload_register();

use Business\winkelkarService;
use Business\artikelService;
use Business\recensieService;

session_start();

//aanmaken van winkelkar sessie array indien deze leeg is

if (!isset($_SESSION["winkelkar"])) {
    $_SESSION["winkelkar"] = [];
}

//Als de get actie addCart is meegegven, stuur dan het productId en het aantal door naar de bussiness. 
//Opgehaalde winkelkarobject opslaan in de sessie array

if(isset($_GET["action"]) && ($_GET["action"] === "addCart")){

    $aantal = $_GET["aantal"];
    $productId = $_GET["id"];

    $winkelkarService = new winkelkarService();
    $winkelkarObject = $winkelkarService->voegItemToe((int) $productId, (int) $aantal);
    
    $winkelkarObject = serialize($winkelkarObject);

    array_push($_SESSION["winkelkar"], $winkelkarObject);  
}

include("Presentation/artikelPagina.php");




