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
use Data\ArtikelDAO;



class ArtikelDAO
{

  

    private string $metScores = "WITH scores(rating, id) AS (SELECT AVG(score), artikelId FROM klantenreviews inner JOIN bestellijnen on klantenreviews.bestellijnId = bestellijnen.bestellijnId GROUP BY artikelId), 
    artikelenMetScores AS (SELECT artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd, rating FROM artikelen LEFT OUTER JOIN scores on artikelen.artikelId = scores.id)";
    public function metPaginas(string $sql, int $pagina, int $aantal = 20): string
    {
        return $sql . " LIMIT " . (int) ($pagina - 1) * $aantal . ", " . $aantal;
    }
    /*
    select artikelen.artikelId as artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd, ROUND(AVG(score)) as rating from artikelen, bestellijnen, klantenreviews where artikelen.artikelId = bestellijnen.artikelId and bestellijnen.bestellijnId = klantenreviews.bestellijnId group by artikelId order by rating desc limit 0,3; 

     */

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
        $statement = $dbh->prepare($this->metScores . "select * from artikelenMetScores ORDER BY $volgorde LIMIT ". ($pagina-1)*$aantalPerPagina . ", ". $aantalPerPagina);
        
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
                (int) $rij["levertijd"]
            );
            $artikel->setRating((float) $rij["rating"]);
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
	    $artikel = new Artikel((int) $rij["artikelId"], $rij["ean"], $rij["naam"], $rij["beschrijving"], (float) $rij["prijs"], 
            (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"]);
            $artikel->setRating((float) $rating);
	    $dbh = null;
	    return $artikel;
    }

    public function getAantalArtikelRijen(string $volgorde = "rating DESC, prijs DESC"): int
    {
        $sql = $this->metScores . "select * from artikelenMetScores ORDER BY $volgorde";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);
        $aantalRijen = $resultSet->rowCount();
        $dbh = null;
        return $aantalRijen;
    }

    /*Tom: Ik dacht dat de functie hieronder het juiste resultaat zou geven, maar als ik ze uittest gaat er iets mis en ik begrijp
    niet goed wat... De query klopt, want die heb ik uitgetest in sql. Dus er moet ergens een fout in de syntax zijn... Kan je mij
    aub ook laten weten wat de fout was als je ze vindt? Blijf graag op de hoogte. :)*/

    //$this->metScores . "select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelenMetScores ORDER BY $volgorde where naam like '%:zoekterm%' LIMIT ". ($pagina-1)*$aantalPerPagina . ", ". $aantalPerPagina
   
    public function zoekArtikelen(string $zoekterm, int $pagina = 1, int $aantalPerPagina = 20, string $volgorde = "rating DESC, prijs DESC"):? Array {
        $sql = $this->metScores . "select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelenMetScores ORDER BY $volgorde where naam like '%:zoekterm%' LIMIT ". ($pagina-1)*$aantalPerPagina . ", ". $aantalPerPagina;
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
                (int) $rij["gewichtInGram"], (int) $rij["voorraad"], (int) $rij["levertijd"]);
                $artikel->setRating((float) $rating);
                array_push($lijst, $artikel);
            }
           $dbh = null;
           return $lijst;
        }
    }

   public function getAantalZoekArtikelRijen(string $zoekterm, string $volgorde = "rating DESC, prijs DESC"): int
     { 
        
        $sql = $this->metScores . "select artikelId, ean, naam, beschrijving, prijs, gewichtInGram, voorraad, levertijd from artikelenMetScores ORDER BY $volgorde where naam like '%m%' ";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        //$stmt->bindValue(':zoekterm', $zoekterm);
        $stmt->execute();
        $aantalRijen = $stmt->rowCount();

        $dbh = null;
        return $aantalRijen;
    } 

    

}