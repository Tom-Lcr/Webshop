<?php
//Data/ArtikelDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Artikel;


class ArtikelDAO {
    
    //Onderste functie geeft alle artikelen gewoon terug

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

    /*Onzeker over onderste functie, maar de query klopt wanneer ik hem uitprobeer in sql. De bedoeling is om gewoon
    het getal uit de database te krijgen dat overeenkomt met hun score (som/aantal)*/

    public function getScoreByArtikelId(int $artikelId) :? int {
        $sql = "select bestellijnen.artikelId as artikelId, (sum(score)/count(score)) as totale_score from bestellijnen, 
        klantenreviews where bestellijnen.bestellijnId = klantenreviews.bestellijnId and artikelId = :artikelid";
	$dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
	$stmt = $dbh->prepare($sql);
    $stmt->execute(array(':artikelId' => $artikelId));
	$rij = $stmt->fetch(PDO::FETCH_ASSOC);
	$score = intval($rij["totale_score"]);
	$dbh = null;
	return $score;
    }
	


   

}