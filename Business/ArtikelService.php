<?php
declare(strict_types = 1);

namespace Business;

use Data\ArtikelDAO;



class ArtikelService {

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

