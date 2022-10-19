<?php
//Data/ArtikelDAO

declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Artikel;
use Data\ArtikelDAO;



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

    public function getAll(int $waarde1, int $waarde2): array {
        $optelwaarde = $waarde1 + $waarde2;
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare("select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd 
        from artikelen where artikelId > :wrd1 and artikelId <= :wrd2");
        $statement->bindValue(":wrd1", $waarde1);
        $statement->bindValue(":wrd2", $optelwaarde);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $lijstMetAantal = array();
        $lijst = array();
        foreach($resultSet as $rij){
            $artikeldao = new ArtikelDAO;
            $rating = $artikeldao->getRatingByArtikelId((int)$rij["artikelId"]);
            $artikel = new Artikel((int) $rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float) $rij["prijs"], 
            (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"], $rating);
            array_push($lijst, $artikel);
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

    /*Tom: Ik dacht dat de functie hieronder het juiste resultaat zou geven, maar als ik ze uittest gaat er iets mis en ik begrijp
    niet goed wat... De query klopt, want die heb ik uitgetest in sql. Dus er moet ergens een fout in de syntax zijn... Kan je mij
    aub ook laten weten wat de fout was als je ze vindt? Blijf graag op de hoogte. :)*/
   
    public function zoekArtikelen(string $zoekterm):? Array {
        $sql = "select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelen
        where naam like %:zoekterm%";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);  
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':zoekterm' => $zoekterm));
        $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$resultSet) {
            return null;
        } else { 
            $lijst = array();  
            foreach($resultSet as $rij){
                $artikeldao = new ArtikelDAO;
                $rating = $artikeldao->getRatingByArtikelId((int)$rij["artikelId"]);
                $artikel = new Artikel((int) $rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float) $rij["prijs"], 
                (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"], $rating);
                array_push($lijst, $artikel);
            }
           $dbh = null;
           return $lijst;
    }

}

}




