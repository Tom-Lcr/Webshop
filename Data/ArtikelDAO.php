<?php
//Data/ArtikelDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Artikel;
use Entities\Categorie;


class ArtikelDAO {
    
    //Onderste functie berekent rating op basis van artikelID
     /*Onzeker over onderste functie, maar de query klopt wanneer ik hem uitprobeer in sql. De bedoeling is om gewoon
    het getal uit de database te krijgen dat overeenkomt met hun score (som/aantal)*/

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


     
   

    /*Onderste functie is onvollodig: de bedoeling zou zijn dat een object Categorie wordt aangemaakt en mee terug gegeven wordt
    om het object Artikel te vervolledigen. Daarvoor moet ik echter eerst in de CategorieDAO een aantal functies schrijven.
    Echter was Jens onzeker of het wel nodig zou zijn dat Object Categorie aan te maken, vandaar niet afgewerkt*/
	

    public function getAll(): Array {
        $sql = "select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelen";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);  
        $resultSet = $dbh->query($sql);
        $lijst = array();
        foreach($resultSet as $rij){
            $rating = getRatingByArtikelId((int)$rij["artikelId"]);
            $artikel = new Artikel((int)$rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float)$rij["prijs"], 
            (int)$rij["gewichtInGram"], (int)$rij["bestelpeil"], (int)$rij["voorraad"], (int)$rij["levertijd"], $rating);
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }

   

    


   

}