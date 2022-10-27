<?php
//Data/PersoonDAO
declare (strict_types = 1);

namespace Data;

use Data\DBConfig;
use \PDO;
use Entities\NatuurlijkePersoon;
use Entities\Rechtspersoon;

class PersoonDAO
{

    public function createNatuurlijkePersoon(int $klantId, $voorNaam, $familieNaam, int $gebruikersAccountId): ?NatuurlijkePersoon
    {

        $sql = "insert into natuurlijkepersonen (klantId, voornaam, familienaam, gebruikersAccountId) values (:klantId, :voornaam, :familienaam, :gebruikersAccountId)";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":klantId", $klantId);
        $stmt->bindValue(":voornaam", $voorNaam);
        $stmt->bindValue(":familienaam", $familieNaam);
        $stmt->bindValue(":gebruikersAccountId", $gebruikersAccountId);
        $stmt->execute();

        $natuurlijkepersoon = new NatuurlijkePersoon($voorNaam, $familieNaam);

        $dbh = null;
        return $natuurlijkepersoon;
    }

    public function createContactPersoon($naam, $btwNummer, $voorNaam, $familieNaam, $functie, int $klantId, int $gebruikersAccountId): ?Rechtspersoon
    {

        $this->createRechtspersoon((int) $klantId, $naam, $btwNummer);
        $sql = "insert into contactpersonen (voornaam, familienaam, functie, klantId, gebruikersAccountId) values (:voornaam, :familienaam, :functie, :klantId, :gebruikersAccountId)";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":voornaam", $voorNaam);
        $stmt->bindValue(":familienaam", $familieNaam);
        $stmt->bindValue(":functie", $functie);
        $stmt->bindValue(":klantId", $klantId);
        $stmt->bindValue(":gebruikersAccountId", $gebruikersAccountId);
        $stmt->execute();
        $contactId = $dbh->lastInsertId();

        $rechtspersoon = new Rechtspersoon($naam, $btwNummer, (int) $contactId, $voorNaam, $familieNaam, $functie);

        $dbh = null;
        return $rechtspersoon;
    }

    public function createRechtspersoon(int $klantId, $naam, $btwNummer)
    {

        $sql = "insert into rechtspersonen (klantId, naam, btwNummer) values (:klantId, :naam, :btwNummer)";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":klantId", $klantId);
        $stmt->bindValue(":naam", $naam);
        $stmt->bindValue(":btwNummer", $btwNummer);
        
        $stmt->execute();

        

        $dbh = null;
        
    }

}
