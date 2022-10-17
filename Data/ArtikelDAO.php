<?php
//Data/ArtikelDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Artikel;


class ArtikelDAO {
    
    /* Functie hieronder in commentaar gezet omdat ik niet weet of ik ze nog ga nodig hebben */
    
   /* public function getAllVolgensScore(): Array {
        $sql = "select artikelen.artikelId as artikelId, bestellijnen.bestellijnId as bestellijnId, 
        score, ean, naam, beschrijving, prijs, gewichtInGram, bestelpeil, voorraad, minimumVoorraad, maximumVoorraad, levertijd, 
        aantalBesteldLeverancier, maxAantalInMagazijnPlaats from artikelen, bestellijnen, klantenreviews where 
        artikelen.artikelId = bestellijnen.artikelId and bestellijnen.bestellijnId = klantenreviews.bestellijnId order by score desc";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);  
        $resultSet = $dbh->query($sql);
        $lijst = array();
        foreach($resultSet as $rij){
      De Entiteit Artikel zal normaal niet alle properties bevatten die het hier terug geeft daar Klantenreviews score bevat en
      dit een andere entiteit is       
         $artikel = new Artikel((int)$rij["artikelId"], (int)$rij["bestellijnId"], (int)$rij["score"], 
            $rij["ean"], $rij["naam"], $rij["beschrijving"], (float)$rij["prijs"], (int)$rij["gewichtInGram"], (int)$rij["bestelpeil"], 
            (int)$rij["voorraad"], (int)$rij["minimumVoorraad"], (int)$rij["maximumVoorraad"], (int)$rij["levertijd"], 
            (int)$rij["aantalBesteldLeverancier"], (int)$rij["maxAantalInMagazijnPlaats"]);
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }*/ 

    // Onderste functie geeft gewoon alle artikelen terug zonder meer:

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

    // De query hieronder klopt, op basis van het artikelId krijg je een score indien er één is (dus indien er ook een bestellijn van is)
    // Zoek een volledige Klantenreview op op basis van artikelId en geef object Klantenreview terug
    public function getScoreByArtikelId(int $artikelId) :? Klantenreview {
        $sql = "select bestellijnen.artikelId as artikelId, score from bestellijnen, klantenreviews where 
        bestellijnen.bestellijnId = klantenreviews.bestellijnId and artikelId = :artikelid";
	$dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
	$stmt = $dbh->prepare($sql);
    $stmt->execute(array(':artikelId' => $artikelId));
	$rij = $stmt->fetch(PDO::FETCH_ASSOC);
	$genre = Genre::create((int)$rij["genre_id"], $rij["genre"]);
	$boek = new Boek((int)$rij["boek_id"], $rij["titel"], $genre);
	$dbh = null;
	return $boek;
    }
	


   

}