<?php
//Data/ArtikelDAO

declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Artikel;
use Entities\Opties;

class ArtikelDAO
{

    //todo: string metScores aanpassen, kolom heeftRating (boolean) toevoegen aan artikelenMetScores,
    //zodat bij oplopend sorteren op rating artikelen die rating hebben bovenaan gezet kunnen worden
    private string $metScores = "WITH scores(rating, id) AS (SELECT AVG(score), artikelId FROM klantenreviews inner JOIN bestellijnen on klantenreviews.bestellijnId = bestellijnen.bestellijnId GROUP BY artikelId), 
    artikelenMetScores AS (SELECT artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd, rating FROM artikelen LEFT OUTER JOIN scores on artikelen.artikelId = scores.id)";

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

    public function getArtikels(Opties $opties, int $pagina = 1, int $aantalPerPagina = 20) : array
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare($this->metScores . "select * from artikelenMetScores " . $opties->getQuery() . " LIMIT " . ($pagina - 1) * $aantalPerPagina . ", " . $aantalPerPagina);

        //$statement->bindValue(":volgorde", $volgorde);

        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $lijst = array();
        foreach ($resultSet as $rij) {
            $artikel = new Artikel(
                (int) $rij["artikelId"],
                $rij["ean"],
                $rij["naam"],
                $rij["beschrijving"],
                (float) $rij["prijs"],
                (int) $rij["gewichtInGram"],
                (int) $rij["voorraad"],
                (int) $rij["levertijd"],
                (float) $rij["rating"]
            );
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
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
        $artikel = new Artikel(
            (int) $rij["artikelId"],
            $rij["ean"],
            $rij["naam"],
            $rij["beschrijving"],
            (float) $rij["prijs"],
            (int) $rij["gewichtInGram"],
            (int) $rij["voorraad"],
            (int) $rij["levertijd"]
        );
        $artikel->setRating((float) $rating);
        $dbh = null;
        return $artikel;
    }

    public function getAantalArtikelRijen($opties)
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare($this->metScores . "select * from artikelenMetScores " . $opties->getQuery());        
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        return count($resultSet);
    }
}
