<?php

declare(strict_types=1);

spl_autoload_register();

use Business\winkelkarService;
use Business\artikelService;
use Business\recensieService;

if(isset($_GET["action"]) && ($_GET["action"] === "addCart")){
    $aantal = $_GET["aantal"];
    $productId = $GET["id"];

    /* Bussinesslaag aanspreken, productId en aantal toevoegen aan winkelkar */
    
    /*$winkelkarService = new winkelkarService();
    $winkelkarService->voegArtikelToe((int) $productId, (int) $aantal);*/
}

include("Presentation/artikelPagina.php");




