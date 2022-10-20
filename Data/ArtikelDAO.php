<?php
//Data/ArtikelDAO

//pagination met limit, zie bvb:
//https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html

declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Business\CategorieService;
use Entities\Artikel;



class ArtikelDAO
{
    private string $metScores = "WITH scores(rating, id) AS (SELECT AVG(score), artikelId FROM klantenreviews inner JOIN bestellijnen on klantenreviews.bestellijnId = bestellijnen.bestellijnId GROUP BY artikelId), 
    artikelenMetScores AS (SELECT artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd, rating FROM artikelen LEFT OUTER JOIN scores on artikelen.artikelId = scores.id)";
    public function metPaginas(int $pagina, int $aantal = 20): string
    {
        return " LIMIT " . (int) ($pagina - 1) * $aantal . ", " . $aantal;
    }

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

    public function getAll(int $pagina = 1, int $aantalPerPagina = 20, string $volgorde = "rating DESC, prijs DESC"): array
    {
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);        
        $statement = $dbh->prepare($this->metScores . "SELECT * FROM artikelenMetScores ORDER BY $volgorde LIMIT ". ($pagina-1)*$aantalPerPagina . ", ". $aantalPerPagina);
        
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
                (int) $rij["rating"]
            );
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }



    public function getAantalArtikelRijen(): int
    {
        $sql = "select * from artikelen";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
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




    


