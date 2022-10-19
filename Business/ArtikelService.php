<?php
//Business/ArtikelService.php
declare(strict_types = 1);

namespace Business;

use Data\ArtikelDAO;
use Entities\Artikel;


class ArtikelService {
 
   

    public function getRating($artikelId): float {
        $artikelDAO = new ArtikelDAO();
        $rating = $artikelDAO->getRatingByArtikelId($artikelId);
        return $rating;
    }

    public function getArtikelOverzicht(int $waarde1, int $waarde2) : array {
        $artikelDAO = new ArtikelDAO();
        $lijst = $artikelDAO->getAll((int) $waarde1, (int) $waarde2);
        return $lijst;
    }	

    public function getAantalArtikelRijen() : int {
        $artikelDAO = new ArtikelDAO();
        $aantalArtikelRijen = $artikelDAO->getAantalArtikelRijen();
        return $aantalArtikelRijen;
    }
<<<<<<< HEAD
=======


//geeft alle artikels die tot een categorie behoren (inclusief de subcategorieen), voor presentatie wanneer op een bepaalde categorie gefilterds is
    public function getArtikelsByCategorieId(int $categorieId): array
    {
        return (new ArtikelDAO)->getArtikelsByCategorieID($categorieId);
    }
>>>>>>> e95bd6f51fa3e8ede1524eba47572ef76501cc55
         
} 


