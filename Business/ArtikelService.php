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

    public function zoekArtikelen($zoekterm) :? array {
        $artikelDAO = new ArtikelDAO();
        $gevondenArtikelen = $artikelDAO->zoekArtikelen($zoekterm);
        return $gevondenArtikelen;
    }
    
=======
>>>>>>> 30ec5f21f73f443f8714e0f27049a98226a6ac87
         
} 


