<?php

declare(strict_types=1);

spl_autoload_register();

use Business\WinkelkarService;
use Business\ArtikelService;
use Entities\Winkelkar;
//use Business\RecensieService;

session_start();

$artikelSvc = new ArtikelService();
$winkelkarLijst = array();
$winkelkarAantal = array();

if (isset($_GET["action"]) && $_GET["action"] === "process") {
    $teller2 = 0;
    foreach ($_SESSION["winkelmand"] as $item) {
        $winkelkarItem = unserialize($item);
        $artikelInputAantal = "aantalInWinkelkar" . $teller2;
        if ($winkelkarItem->getAantal() < $_POST[$artikelInputAantal]) {
            $winkelkarItem->setAantal($winkelkarItem->getAantal() + ($_POST[$artikelInputAantal] - $winkelkarItem->getAantal()));
            $_SESSION["aantalitems"] += ($_POST[$artikelInputAantal] - $winkelkarItem->getAantal());
            $_SESSION["winkelmand"][$teller2] = serialize($winkelkarItem);
        }else if ($winkelkarItem->getAantal() > $_POST[$artikelInputAantal]) {
            $winkelkarItem->setAantal($winkelkarItem->getAantal() - ($winkelkarItem->getAantal() - $_POST[$artikelInputAantal]));
            $_SESSION["aantalitems"] -= ($winkelkarItem->getAantal() - $_POST[$artikelInputAantal]);
            $_SESSION["winkelmand"][$teller2] = serialize($winkelkarItem);
        }
        
        $teller2++;
    }
    header("location: ./afrekenPaginaController.php");
    exit(0);
}


if (isset($_GET["action"]) && $_GET["action"] === "delete") {
    
        $winkelKarItemTeller = (int) $_GET["id"];
        array_splice($_SESSION["winkelmand"], $winkelKarItemTeller, 1);   
        
}


if (isset($_SESSION["winkelmand"]) && isset($_SESSION["aantalitems"])) {
    $_SESSION["totaalPrijs"] = 0;
    $_SESSION["aantalitems"] = 0;
      foreach ($_SESSION["winkelmand"] as $item) {
            $winkelkarItem = unserialize($item);
            $_SESSION["aantalitems"] += $winkelkarItem->getAantal();
            $artikel = $artikelSvc->getArtikelById((int) $winkelkarItem->getProductId());
            $_SESSION["totaalPrijs"] += ($artikel->getPrijs() * $winkelkarItem->getAantal());
            array_push($winkelkarAantal, $winkelkarItem->getAantal());
            array_push($winkelkarLijst, $artikel);
      }
      
}

include("Presentation/winkelKarPagina.php");



