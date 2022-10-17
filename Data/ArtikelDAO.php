<?php
//Data/ArtikelDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Artikel;


class ArtikelDAO {
    
    
    public function getAll(): Array {
        $sql = "select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, bestelpeil, voorraad,
        minimumVoorraad, maximumVoorraad, levertijd, aantalBestelIdLeverancier, maxAantalInMagazijnPlaats from artikelen";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);  
        $resultSet = $dbh->query($sql);
        $lijst = array();
        foreach($resultSet as $rij){
            $artikel = new Artikel((int)$rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], 
            (int)$rij["gewichtInGram"], (int)$rij["bestelpeil"], (int)$rij["voorraad"], (int)$rij["minimumVoorraad"], 
            (int)$rij["maximumVoorraad"], (int)$rij["levertijd"], (int)$rij["aantalBestelIdLeverancier"], 
            (int)$rij["maxAantalInMagazijnPlaats"]);
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }


   

}