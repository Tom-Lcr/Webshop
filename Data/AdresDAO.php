<?php
//Data/AdresDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Data\PlaatsDAO;
use Entities\Adres;


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
        
        $adres = new Adres((int)$adresId, $straatNaam, (int) $huisNummer, $bus, $plaats, true);
    
        $dbh = null;    
        return $adres;
        }    


}