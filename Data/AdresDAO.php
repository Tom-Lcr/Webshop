<?php
//Data/AdresDAO
declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Adres;
use Entities\Plaats;

class AdresDAO
{    
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
