<?php
//Data/PlaatsDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Plaats;


class PlaatsDAO {
    
    
    public function getPlaatsByPlaatsId(int $plaatsId) : Plaats  {
        $sql = "select * from plaatsen where plaatsId = :plaatsId;";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':plaatsId' => $plaatsId));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $plaats = new Plaats((int)$rij["plaatsId"], $rij["plaats"], $rij["postcode"]);
        $dbh = null;
        return $plaats;
        }


   

}