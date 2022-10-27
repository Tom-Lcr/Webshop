<?php
//Data/BestellingDAO
declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use DateTime;
use Entities\ActieCode;
use Entities\Bestellijn;
use Exceptions\ActieCodeBestaatNietException;
use Exceptions\ActieCodeNietMeerGeldigException;
use Exceptions\DatabaseException;
use PDOException;


class BestellijnDAO
{
    public function voegBestelRegelToe(Bestellijn $bestellijn, $dbh)
    {
        try {
            $sql = "insert into bestellijnen (bestelId, artikelId, aantalBesteld, aantalGeannuleerd) values (:bestelId, :artikelId, :aantal, 0)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":bestelId", $bestellijn->getBestelId());
            $stmt->bindValue(":artikelId", $bestellijn->getArtikelId());
            $stmt->bindValue(":aantal", $bestellijn->getAantalBesteld());            
            $stmt->execute();
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    public function getBestellijnenByBestelId(int $bestelId) : array  {
        $sql = "select * from bestellijnen where bestelId = :bestelId;";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':bestelId' => $bestelId));
        $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $bestellijnen = array();
        foreach($resultset as $rij)	{
            $bestellijn = new Bestellijn((int)$rij["bestellijnId"], (int)$rij["bestelId"], (int)$rij["artikelId"], 
            (int)$rij["aantalBesteld"], (int)$rij["aantalGeannuleerd"]);
            array_push($bestellijnen, $bestellijn);
        }
        $dbh = null;
        return $bestellijnen;
        }
}
