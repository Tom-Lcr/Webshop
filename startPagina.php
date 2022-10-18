<?php
declare(strict_types = 1);

spl_autoload_register();

use Business\ArtikelService;


$artikelSvc = new ArtikelService();
$aantalArtikelsPerPagina = 20;
$aantalRijen = $artikelSvc->getAantalArtikelRijen();
$aantalPaginas = ceil($aantalRijen / $aantalArtikelsPerPagina);
if (isset($_GET["page"])) {
    $pagina = $_GET["page"];
    if ($pagina < 1) { 
        $pagina = 1; 
    } else if ($pagina > $aantalPaginas) { 
        $pagina = $aantalPaginas; 
    }  
	} else {
    $pagina = 1;         
    }
$eerstePaginaArtikel = ($pagina-1)*$aantalArtikelsPerPagina;
$artikelLijst = $artikelSvc->getArtikelOverzicht((int) $eerstePaginaArtikel, (int) $aantalArtikelsPerPagina);




include("Presentation/startPagina.php");