<?php
//Data/ArtikelDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Artikel;


class ArtikelDAO {
    
    /* Onderste functie klopt niet; geeft enkel Artikelen terug die ook voorkomen in klantenreviews en een score hebben gehad. 
    We zullen andere manier van rangschikken moeten voorzien */
    
    public function getAllVolgensScore(): Array {
        $sql = "select artikelen.artikelId as artikelId, bestellijnen.bestellijnId as bestellijnId, 
        score, ean, naam, beschrijving, prijs, gewichtInGram, bestelpeil, voorraad, minimumVoorraad, maximumVoorraad, levertijd, 
        aantalBesteldLeverancier, maxAantalInMagazijnPlaats from artikelen, bestellijnen, klantenreviews where 
        artikelen.artikelId = bestellijnen.artikelId and bestellijnen.bestellijnId = klantenreviews.bestellijnId order by score desc";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);  
        $resultSet = $dbh->query($sql);
        $lijst = array();
        foreach($resultSet as $rij){
            $artikel = new Artikel((int)$rij["artikelId"], (int)$rij["bestellijnId"], (int)$rij["score"], 
            $rij["ean"], $rij["naam"], $rij["beschrijving"], (float)$rij["prijs"], (int)$rij["gewichtInGram"], (int)$rij["bestelpeil"], 
            (int)$rij["voorraad"], (int)$rij["minimumVoorraad"], (int)$rij["maximumVoorraad"], (int)$rij["levertijd"], 
            (int)$rij["aantalBesteldLeverancier"], (int)$rij["maxAantalInMagazijnPlaats"]);
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }

    // Onderste functie geeft gewoon alle artikelen terug:

    public function getAll(): Array {
        $sql = "select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, bestelpeil, voorraad, minimumVoorraad, 
        maximumVoorraad, levertijd, aantalBesteldLeverancier, maxAantalInMagazijnPlaats from artikelen";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);  
        $resultSet = $dbh->query($sql);
        $lijst = array();
        foreach($resultSet as $rij){
            $artikel = new Artikel((int)$rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float)$rij["prijs"], 
            (int)$rij["gewichtInGram"], (int)$rij["bestelpeil"], (int)$rij["voorraad"], (int)$rij["minimumVoorraad"], 
            (int)$rij["maximumVoorraad"], (int)$rij["levertijd"], (int)$rij["aantalBesteldLeverancier"], 
            (int)$rij["maxAantalInMagazijnPlaats"]);
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }


   

}