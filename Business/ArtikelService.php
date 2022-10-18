<?php
//Business/ArtikelService.php
declare(strict_types = 1);

namespace Business;

use Data\ArtikelDAO;
use Entities\Artikel;


class ArtikelService {
 
    //Deze twee functies bouwen voort op de 2 functies uit de artikelDAO

    public function getOverzicht(): array {
        $artikelDAO = new ArtikelDAO();
        $lijst = $artikelDAO->getAll();
        return $lijst;
    }

    public function getRating($artikelId): int {
        $artikelDAO = new ArtikelDAO();
        $score = $artikelDAO->getRatingByArtikelId($artikelId);
        return $score;
    }

    
         
} 
