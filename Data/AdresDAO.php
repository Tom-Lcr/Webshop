<?php
//Data/AdresDAO
declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Data\PlaatsDAO;
use Entities\Adres;
use Entities\Plaats;


class AdresDAO {
    
    public function create($straatNaam, $huisNummer, $bus, $postcode, $plaatsNaam): ?Adres {
        
        $plaatsDAO = new PlaatsDAO();
        $plaats = $plaatsDAO->create($postcode, $plaatsNaam);
        $plaatsId = $plaats->getPLaatsId(); 
        $sql = "insert into adressen (straat, huisNummer, bus, plaatsId, actief) values (:straat, :huisNummer, :bus, :plaatsId, :actief)";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":straat", $straatNaam);
        $stmt->bindValue(":huisNummer", $huisNummer);
        $stmt->bindValue(":bus", $bus);
        $stmt->bindValue(":plaatsId", $plaatsId);
        $stmt->bindValue(":actief", 1);
        $stmt->execute();	
        $adresId = $dbh->lastInsertId();
        
        $adres = new Adres((int)$adresId, $straatNaam, (string) $huisNummer, $bus, $plaats, true);
    
        $dbh = null;    
        return $adres;
        }    


   
    public function getAdresById(int $id)
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("SELECT * FROM adressen WHERE adresId = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $resultSet = $stmt->fetch(PDO::FETCH_ASSOC);
        $plaats = (new PlaatsDAO())->getPlaatsById((int) $resultSet["plaatsId"]);
        $adres = new Adres($id, $resultSet["straat"], $resultSet["huisNummer"], $resultSet["bus"], $plaats);
        $dbh = null;
        return $adres;
    }
}
