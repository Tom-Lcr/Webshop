<?php
//Data/ActieCodeDAO
declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use DateTime;
use Entities\ActieCode;
use Exceptions\ActieCodeBestaatNietException;
use Exceptions\ActieCodeNietMeerGeldigException;
use Exceptions\DatabaseException;
use PDOException;

class ActieCodeDAO
{

    //voorlopig controleren of actiecode bestaat en nog geldig
    //todo: controleren of gebruiker ze nog niet gebruikt heeft bij niet eenmalige codes
    // bij eenmalige codes: controleren of geen enkele gebruiker ze gebruikt heeft
    //probleem: bij bestellingen enkel actiecodegebruikt, niet welke code, dus er kan niet gecontroleerd worden of een herbruikbare code
    //reeds gebruikt is door een klant. Een éénmalige code zou eventueel verwijdert kunnen worden zodat ze niet kan hergebruikt worden

    public function controleerActiecode(string $naam)
    {

        $sql = "SELECT * FROM actiecodes WHERE naam = :naam";
        try {
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(':naam' => $naam));
            $rij =  $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$rij) throw new ActieCodeBestaatNietException();            
            $actiecode = new ActieCode((int)$rij["actiecodeId"], $rij["naam"], new DateTime('@' .strtotime($rij["geldigVanDatum"])), new DateTime('@' .strtotime($rij["geldigTotDatum"])), (bool) $rij["isEenmalig"]);
            if($actiecode->getGeldigTotDatum()< new DateTime() ||$actiecode->getGeldigVanDatum() > new DateTime()) throw new ActieCodeNietMeerGeldigException();      
            $dbh = null;
            return true;

        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
}
