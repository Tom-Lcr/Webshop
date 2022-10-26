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
}
