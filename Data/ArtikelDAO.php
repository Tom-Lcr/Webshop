<?php
//Data/ArtikelDAO

declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
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

    public function getEerste46(int $waarde1, int $waarde2): array {
        $optelwaarde = $waarde1 + $waarde2;
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare("select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelen where artikelId > :wrd1 and artikelId <= :wrd2");
        $statement->bindValue(":wrd1", $waarde1);
        $statement->bindValue(":wrd2", $optelwaarde);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $lijstMetAantal = array();
        $lijst = array();
        foreach($resultSet as $rij){
            $artikel = new Artikel((int) $rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float) $rij["prijs"], (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"]);
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }
     
   

    /*Onderste functie geeft een lijst terug van alle artikel objecten in de database. De rating staat er niet bij in de database
    maar haal ik uit de tabel klantenreviews. Een object Artikel heeft ook een rating nodig conform de Entity die opgemaakt werd. 
    Zo kunnen we ook gaan sorteren op de startpagina uiteindelijk.*/
	

    public function getAll(): Array {
        $sql = "select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelen";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);  
        $resultSet = $dbh->query($sql);
        $lijst = array();
        foreach($resultSet as $rij){
            $artikeldao = new ArtikelDAO;
            $rating = $artikeldao->getRatingByArtikelId((int)$rij["artikelId"]);
            $artikel = new Artikel((int)$rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float)$rij["prijs"], 
            (int)$rij["gewichtInGram"], (int)$rij["voorraad"], (int)$rij["levertijd"], $rating);
            array_push($lijst, $arikel);
        }
        $dbh = null;
        return $lijst;
    }
    

    public function getAantalArtikelRijen(): int {
        $sql = "select * from artikelen";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);
        $aantalRijen = $resultSet->rowCount();
        $dbh = null;
        return $aantalRijen;
    }


}

