<?php

declare(strict_types=1);

spl_autoload_register();

<<<<<<< HEAD
<<<<<<< HEAD
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

=======
=======
>>>>>>> a228ac0260054cfe94db7737862107f05e07c3f4
use Business\WinkelkarService;
use Business\ArtikelService;
//use Business\RecensieService;

session_start();


$artikelSvc = new ArtikelService();
/*
if (isset($_GET["productId"])) {
$gekozenArtikel = $artikelSvc->getArtikelById((int)$_GET["productId"]);
} */

$gekozenArtikel = $artikelSvc->getArtikelById((int)$_GET["productId"]);

$error = "";
if (!isset($_SESSION["aantalitems"])){
    $_SESSION["aantalitems"] = 0;
}


if (isset($_GET["action"]) && $_GET["action"] == "voegToe" && isset($gekozenArtikel)) {
    if ($gekozenArtikel->getVoorraad() >= 1) {
    $winkelkarSvc = new WinkelkarService();
    $winkelkarArtikel = $winkelkarSvc->voegItemToe((int)$_GET["productId"], (int)$_POST["aantalVanArtikel"]);
    $_SESSION["aantalitems"] += $winkelkarArtikel->getAantal();
    $_SESSION["winkelmand"][] = serialize($winkelkarArtikel);
    }else{
        $error = "Dit product is niet in voorraad";
    }
}


<<<<<<< HEAD
>>>>>>> main
=======
>>>>>>> a228ac0260054cfe94db7737862107f05e07c3f4
include("Presentation/artikelPagina.php");




