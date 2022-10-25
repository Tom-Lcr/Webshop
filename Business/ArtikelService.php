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

    public function getArtikelOverzicht(int $waarde1, int $waarde2, string $volgorde) : array {
        $artikelDAO = new ArtikelDAO();
        $lijst = $artikelDAO->getAll((int) $waarde1, (int) $waarde2, $volgorde);
        return $lijst;
    }
    

    public function getAantalArtikelRijen() : int {
        $artikelDAO = new ArtikelDAO();
        $aantalArtikelRijen = $artikelDAO->getAantalArtikelRijen();
        return $aantalArtikelRijen;
    }

    public function zoekArtikelen($zoekterm, int $waarde1, int $waarde2) :? array {
        $artikelDAO = new ArtikelDAO();
        $gevondenArtikelen = $artikelDAO->zoekArtikelen($zoekterm, (int) $waarde1, (int) $waarde2);
        return $gevondenArtikelen;
    }

    public function getArtikelById(int $artikelId): ?Artikel
    {
        $artikelDAO = new ArtikelDAO();
        return $artikelDAO->getArtikelById((int) $artikelId);
    }
    
    public function getAantalZoekArtikelRijen(string $zoekterm) : int {
        $artikelDAO = new ArtikelDAO();
        $aantalArtikelRijen = $artikelDAO->getAantalZoekArtikelRijen($zoekterm);
        return $aantalArtikelRijen;
    }
         
} 


