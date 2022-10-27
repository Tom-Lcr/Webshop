<?php
//Business/ArtikelService.php
declare(strict_types=1);

namespace Business;

use \Data\ArtikelDAO;
use Entities\Artikel;
use Entities\Opties;

class ArtikelService
{

    public function getArtikelLijst(Opties $opties, int $pagina = 1, int $aantalPerPagina = 20)    {
        return(new ArtikelDAO())->getArtikels($opties, $pagina, $aantalPerPagina);
    }

    public function getAantalArtikels(Opties $opties)    {
        return(new ArtikelDAO())->getAantalArtikelRijen($opties);
    }

    public function getRating($artikelId): float
    {
        $artikelDAO = new ArtikelDAO();
        $rating = $artikelDAO->getRatingByArtikelId($artikelId);
        return $rating;
    }

    public function getArtikelById(int $artikelId): ?Artikel
    {
        $artikelDAO = new ArtikelDAO();
        return $artikelDAO->getArtikelById((int) $artikelId);
    }
}
