<?php
//Data/ArtikelDAO

declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Business\CategorieService;
use Entities\Artikel;



class ArtikelDAO {
    
    //Onderste functie berekent rating op basis van artikelID
     /*De query haalt normaal gesproken het getal uit de database dat overeenkomt met hun score (som/aantal)*/

    public function getRatingByArtikelId(int $artikelId) :? float {
        $sql = "select bestellijnen.artikelId as artikelId, (sum(score)/count(score)) as rating from bestellijnen, 
        klantenreviews where bestellijnen.bestellijnId = klantenreviews.bestellijnId and artikelId = :artikelId";
	$dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
	$stmt = $dbh->prepare($sql);
    $stmt->execute(array(':artikelId' => $artikelId));
	$rij = $stmt->fetch(PDO::FETCH_ASSOC);
	$rating = floatval($rij["rating"]);
	$dbh = null;
	return $rating;
    }
    /*
    select artikelen.artikelId as artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd, ROUND(AVG(score)) as rating from artikelen, bestellijnen, klantenreviews where artikelen.artikelId = bestellijnen.artikelId and bestellijnen.bestellijnId = klantenreviews.bestellijnId group by artikelId order by rating desc limit 0,3; 

     */

    public function getAll(int $waarde1, int $waarde2): array {
        $optelwaarde = $waarde1 + $waarde2;
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare("select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelen limit " . $waarde1 . "," . $waarde2);
        //$statement->bindValue(":wrd1", (int) $waarde1);
        //$statement->bindValue(":wrd2", (int) $waarde2);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $lijst = array();
        foreach($resultSet as $rij){
            $artikeldao = new ArtikelDAO;
            $rating = $artikeldao->getRatingByArtikelId((int)$rij["artikelId"]);
            $artikel = new Artikel((int) $rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float) $rij["prijs"], 
            (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"]);
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }

    public function getAllArtikelen(): array {
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare("select artikelen.artikelId as artikelId, ean, naam, 
        beschrijving, prijs, gewichtInGram, voorraad, levertijd, ROUND(AVG(score)) as rating 
        from artikelen, bestellijnen, klantenreviews 
        where artikelen.artikelId = bestellijnen.artikelId and 
        bestellijnen.bestellijnId = klantenreviews.bestellijnId group by artikelId 
        order by rating desc");
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $lijst = array();
        foreach($resultSet as $rij){
            $artikel = new Artikel((int) $rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float) $rij["prijs"], 
            (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"]);
            $artikel->setRating((float) $rij["rating"]);
            array_push($lijst, $artikel);
        }
        $volleLijst = $this->getAllArtikelenZR($lijst);
        
        $dbh = null;
        return $volleLijst;
    } 

    public function getAllArtikelenZR(array $rlijst): array {
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare("select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelen");
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        foreach($resultSet as $rij){
            $komtvoor = false;
            foreach($rlijst as $artikel) {
                if ($rij["artikelId"] == $artikel->getArtikelId()) {
                    $komtvoor = true;
                }
            }
            if ($komtvoor == false) {
               
            $artikel = new Artikel((int) $rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float) $rij["prijs"], 
            (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"]);
            array_push($rlijst, $artikel);
            }
        }
        $dbh = null;
        return $rlijst;
    }
   

    public function getAantalArtikelRijen(): int {
        $sql = "select count(*) from artikelen";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $aantalRijen = $rij["count(*)"];
        $dbh = null;
        return $aantalRijen;
    }

    public function getArtikelById(int $artikelId): ?Artikel
    {
	    $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
	    $stmt = $dbh->prepare("select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelen where artikelId = :artikelId");
        $stmt->bindValue(":artikelId", $artikelId);
       	$stmt->execute();
	    $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $artikeldao = new ArtikelDAO;
        $rating = $artikeldao->getRatingByArtikelId((int)$rij["artikelId"]);
	    $artikel = new Artikel((int) $rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float) $rij["prijs"], 
            (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"], $rating);
	    $dbh = null;
	    return $artikel;
    }

    //geeft alle artikelids die tot een bepaalde categorie behoren, inclusief de subcategorieen
    public function getArtikelIdsByCategorieID(int $categorieId): array
    {
        $categorieIds = (new CategorieService())->getAllCategorieIdsByCategorieID($categorieId);
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare("SELECT DISTINCT artikelId FROM artikelcategorieen WHERE categorieId IN (" . implode(',', $categorieIds) . ")");
        //$statement = $dbh->prepare("SELECT * FROM artikelen WHERE artikelId IN ...");
        //$statement->bindValue(":wrd1", $waarde1);

        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $lijst = array();
        foreach ($resultSet as $rij) {
            array_push($lijst, $rij["artikelId"]);
        }
        $dbh = null;
        return $lijst;
    }

    //geeft alle artikels die tot een bepaalde categorie behoren, inclusief de subcategorieen
    public function getArtikelsByCategorieID(int $categorieId): array
    {
        $categorieIds = (new CategorieService())->getAllCategorieIdsByCategorieID($categorieId);
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare("SELECT * FROM artikelen WHERE artikelId IN ( SELECT DISTINCT artikelId FROM artikelcategorieen WHERE categorieId IN (" . implode(',', $categorieIds) . "))");
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $lijst = array();
        $artikeldao = new ArtikelDAO;
        foreach ($resultSet as $rij) {
            $rating = $artikeldao->getRatingByArtikelId((int)$rij["artikelId"]);
            $artikel = new Artikel(
                (int) $rij["artikelId"],
                $rij["ean"],
                $rij["naam"],
                $rij["beschrijving"],
                (float) $rij["prijs"],
                (int) $rij["gewichtInGram"],
                (int) $rij["voorraad"],
                (int) $rij["levertijd"],
                $rating
            );
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }

}

