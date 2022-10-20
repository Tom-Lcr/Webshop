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
    
    public function getArtikelOverzicht2(int $waarde1, int $waarde2) : array {
        $artikelDAO = new ArtikelDAO();
        $lijst = $artikelDAO->getAllArtikelen();
        $lijstgedeelte = array();
        for ($teller = $waarde1 + 1; $teller <= $waarde1 + $waarde2 && $teller < count($lijst); $teller++) {
            array_push($lijstgedeelte, $lijst[$teller]);
        }
        return $lijstgedeelte;
    }

    public function getAantalArtikelRijen() : int {
        $artikelDAO = new ArtikelDAO();
        $aantalArtikelRijen = $artikelDAO->getAantalArtikelRijen();
        return $aantalArtikelRijen;
    }

    public function getArtikelById(int $artikelId): ?Artikel
    {
        $artikelDAO = new ArtikelDAO();
        return $artikelDAO->getArtikelById((int) $artikelId);
    }

    //geeft alle artikels die tot een categorie behoren (inclusief de subcategorieen), voor presentatie wanneer op een bepaalde categorie gefilterds is
    public function getArtikelsByCategorieId(int $categorieId): array
    {
        return (new ArtikelDAO)->getArtikelsByCategorieID($categorieId);
    }
         
} 


