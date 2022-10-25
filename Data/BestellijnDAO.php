<?php
//Data/BestellijnDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Bestellijn;


class BestellijnDAO {
    
    
    public function getBestellijnenByBestelId(int $bestelId) : array  {
        $sql = "select * from bestellijnen where bestelId = :bestelId;";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':bestelId' => $bestelId));
        $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $bestellijnen = array();
        foreach($resultset as $rij)	{
            $bestellijn = new Bestellijn((int)$rij["bestellijnId"], (int)$rij["bestelId"], (int)$rij["artikelId"], 
            (int)$rij["aantalBesteldId"], (int)$rij["aantalGeannuleerd"]);
            array_push($bestellijnen, $bestellijn);
        }
        $dbh = null;
        return $bestellijnen;
        }

   

}

