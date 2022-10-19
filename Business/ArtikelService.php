<?php
//Business/ArtikelService.php
declare(strict_types=1);

namespace Business;

use Data\ArtikelDAO;



class ArtikelService
{
    //geeft alle artikels die tot een categorie behoren
    public function getArtikelsByCategorieId(int $categorieId): array
    {
        return (new ArtikelDAO)->getArtikelsByCategorieID($categorieId);
    }
}
