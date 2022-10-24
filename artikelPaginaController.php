<?php

declare(strict_types=1);

spl_autoload_register();

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


include("Presentation/artikelPagina.php");




