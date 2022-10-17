<?php
//Business/ArtikelService.php
declare(strict_types = 1);

namespace Business;

use Data\ArtikelDAO;
use Entities\Artikel;


class ArtikelService {
    

    public function getOverzicht(): array {
        $artikelDAO = new ArtikelDAO();
        $lijst = $artikelDAO->getAll();
        return $lijst;
    }
    
         
} 
