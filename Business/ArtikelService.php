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

    public function getRating($artikelId): float {
        $artikelDAO = new ArtikelDAO();
        $rating = $artikelDAO->getRatingByArtikelId($artikelId);
        return $rating;
    }

    public function getArtikelOverzicht(int $waarde1, int $waarde2) : array {
        $artikelDAO = new ArtikelDAO();
        $lijst = $artikelDAO->getEerste46((int) $waarde1, (int) $waarde2);
        return $lijst;
    }	

    public function getAantalArtikelRijen() : int {
        $artikelDAO = new ArtikelDAO();
        $aantalArtikelRijen = $artikelDAO->getAantalArtikelRijen();
        return $aantalArtikelRijen;
    }
         
} 


