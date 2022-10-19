<?php

declare(strict_types=1);

namespace Data;

use PDO;
use Data\DBConfig;
use Entities\Categorie;
use Entities\Artikel;
use Business\CategorieService;
use PDOException;
use Exceptions\DatabaseException;

//$sql = "SELECT * FROM table WHERE comp_id IN (" . implode(',', $arr) . ")";
class ArtikelDAO
{

    public function getRatingByArtikelId(int $artikelId): ?float
    {
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
