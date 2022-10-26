<?php
//Data/AdresDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Adres;
use Data\PlaatsDAO;


class AdresDAO {
    
    public function getAdresByAdresId(int $adresId) : Adres  {
        $sql = "select * from adressen where adresId = :adresId;";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':adresId' => $adresId));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $plaatsdao = new PlaatsDAO;
        $plaats = $plaatsdao->getPlaatsByPlaatsId((int)$rij["plaatsId"]);
        $adres = new Adres((int)$rij["adresId"], $rij["straat"], (int)$rij["huisNummer"], $rij["bus"], 
        $plaats, (bool)$rij["actief"]);
        $dbh = null;
        return $adres;
        }

  

}
