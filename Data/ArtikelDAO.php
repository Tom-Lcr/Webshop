<?php
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Artikel;

class ArtikelDAO {
    
    public function getEerste46(int $waarde1, int $waarde2): array {
        $optelwaarde = $waarde1 + $waarde2;
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $statement = $dbh->prepare("select artikelId, naam, prijs, voorraad from artikelen where artikelId > :wrd1 and artikelId <= :wrd2");
        $statement->bindValue(":wrd1", $waarde1);
        $statement->bindValue(":wrd2", $optelwaarde);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $lijstMetAantal = array();
        $lijst = array();
        foreach($resultSet as $rij){
            $artikel = new Artikel((int) $rij["artikelId"], $rij["naam"], (float) $rij["prijs"], (int) $rij["voorraad"]);
            array_push($lijst, $artikel);
        }
        $dbh = null;
        return $lijst;
    }

    public function getAantalArtikelRijen(): int {
        $sql = "select * from artikelen";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING,DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);
        $aantalRijen = $resultSet->rowCount();
        $dbh = null;
        return $aantalRijen;
    }


}

