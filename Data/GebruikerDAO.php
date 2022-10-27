<?php
//Data/GebruikerDAO
declare(strict_types=1);

namespace Data;

use Entities\Rechtspersoon;
use \PDO;
//use Exceptions\TitelBestaatException;
use Data\DBConfig;
use Data\AdresDAO;
use Data\PersoonDAO;
use Entities\Gebruiker;
use Entities\Adres;
use Entities\Persoon;
use Exceptions\GebruikerBestaatAlException;
use Exceptions\OngeldigEmailadresException;
use Exceptions\WachtwoordenKomenNietOvereenException;
use Data\PlaatsDAO;
use Entities\NatuurlijkePersoon;
use Exceptions\WachtwoordVerkeerdException;
use Exceptions\DatabaseException;
use PDOException;
use Exceptions\GebruikerBestaatNietException;


class GebruikerDAO {
    
    public function registreer($familieNaam, $voorNaam, $emailAdres, $paswoord, $herpaswoord, bool $tweeAdressen, bool $isParticulier, $straatNaaml, int $huisNummerl, $postcodel, $plaatsNaaml, $straatNaamf = null, int $huisNummerf = null, $postcodef = null, $plaatsNaamf = null, $bedrijfsNaam, $btwNummer, $functie): ?Gebruiker 
    {
        $adresDAO = new AdresDAO();
        $persoonDAO = new PersoonDAO();
            if (!filter_var($emailAdres, FILTER_VALIDATE_EMAIL)) {
                throw new OngeldigEmailadresException();
            }
            if ($paswoord !== $herpaswoord) {
                throw new WachtwoordenKomenNietOvereenException();
            }
            
            $rowCount = $this->emailReedsInGebruik($emailAdres);
        if ($rowCount > 0) {
            throw new GebruikerBestaatAlException();
        }
            $sql = "insert into gebruikersaccounts (emailadres, paswoord, disabled) VALUES (:emailadres, :paswoord, :disabled)";
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            
            $stmt->bindValue(":emailadres", $emailAdres);
            $stmt->bindValue(":paswoord", $paswoord);
            $stmt->bindValue(":disabled", 0);
            
            $stmt->execute();
            $gebruikersAccountId = $dbh->lastInsertId();
            if ($tweeAdressen) {
                $adresl = $adresDAO->create($straatNaaml, (int) $huisNummerl, $postcodel, $plaatsNaaml);
                $adresf = $adresDAO->create($straatNaamf, (int) $huisNummerf, $postcodef, $plaatsNaamf);
                $klantId = $this->createKlant((int) $adresf->getAdresId(), (int) $adresl->getAdresId());
            }else{
                $adresl = $adresDAO->create($straatNaaml, (int) $huisNummerl, $postcodel, $plaatsNaaml);
                $adresf = $adresl;
                $klantId = $this->createKlant((int) $adresl->getAdresId(), (int) $adresl->getAdresId());
            }
            if ($isParticulier) {
                $persoon = $persoonDAO->createNatuurlijkePersoon((int) $klantId, $voorNaam, $familieNaam, (int) $gebruikersAccountId);
            }else{
                $persoon = $persoonDAO->createContactPersoon($bedrijfsNaam, $btwNummer, $voorNaam, $familieNaam, $functie, (int) $klantId, (int) $gebruikersAccountId);
            }
            

            $gebruiker = new Gebruiker(
                (int)$gebruikersAccountId,
                $emailAdres,
                $paswoord,
                false,
                $klantId,
                $persoon,
                $adresf,
                $adresl
            );
            $dbh = null;

            return $gebruiker;   
    }



    public function createKlant(int $facturatieAdresId, int $leveringsAdresId): ?int {
        
        
	       $sql = "insert into klanten (facturatieAdresId, leveringsAdresId) values (:facturatieAdresId, :leveringsAdresId)";
	       $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
	       $stmt = $dbh->prepare($sql);
           $stmt->bindValue(":facturatieAdresId", $facturatieAdresId);
           $stmt->bindValue(":leveringsAdresId", $leveringsAdresId);
           $stmt->execute();	
	       $klantId = $dbh->lastInsertId();
	

           $dbh = null;    
	       return $klantId;
    }



    public function emailReedsInGebruik($email)
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("SELECT * FROM gebruikersaccounts WHERE emailadres = :email AND disabled = false");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        $dbh = null;
        return $rowCount;
    }

    /*
    public function register(gebruiker $gebruiker)
    {
        $rowCount = $this->emailReedsInGebruik($gebruiker->getEmail());
        if ($rowCount > 0) {
            throw new GebruikerBestaatAlException();
        }

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("INSERT INTO gebruikers (email, naam, voornaam, straat, nummer ,plaatsId, gsm, paswoord, bemerkingen, promoties) 
        VALUES (:email, :naam, :voornaam, :straat, :nummer , :plaatsId, :gsm, :paswoord, :bemerkingen, :promoties)");
        $stmt->bindValue(":email", $gebruiker->getEmail());
        $stmt->bindValue(":paswoord", $gebruiker->getWachtwoord());
        $stmt->bindValue(":naam", $gebruiker->getNaam());
        $stmt->bindValue(":voornaam", $gebruiker->getVoornaam());
        $stmt->bindValue(":straat", $gebruiker->getStraat());
        $stmt->bindValue(":nummer", $gebruiker->getNummer());
        $stmt->bindValue(":plaatsId", $gebruiker->getPlaats()->getId());
        $stmt->bindValue(":gsm", $gebruiker->getGsm());
        $stmt->bindValue(":bemerkingen", $gebruiker->getBemerkingen());
        $stmt->bindValue(":promoties", 0);
        $stmt->execute();
        $laatsteNieuweId = $dbh->lastInsertId();
        $dbh = null;
        $gebruiker->setId((int) $laatsteNieuweId);
        setcookie("emailadres", $gebruiker->getEmail(), time() + 3600*12);
        return $gebruiker;
    }
*/
    public function login($email, $wachtwoord): ?Gebruiker
    {
        $rowCount = $this->emailReedsInGebruik($email);
        if ($rowCount == 0) {
            throw new GebruikerBestaatNietException();
        }

        //ophalen gebruikersaccountId en aanmaken gebruiker object met gebruikersaccountId en email als waarden
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("SELECT * FROM gebruikersaccounts WHERE emailadres = :email and disabled = false");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $resultSet = $stmt->fetch(PDO::FETCH_ASSOC);
        $isWachtwoordCorrect = $wachtwoord === $resultSet["paswoord"];
        if (!$isWachtwoordCorrect) {
            throw new WachtwoordVerkeerdException();
        }

        $gebruiker = new gebruiker($resultSet["gebruikersAccountId"], $email);

        //ophalen gegevens uit natuurlijkepersonen of contact/rechtspersonen en setten persoon en klantId van de gebruiker
        $persoonLijst = $this->getNatuurlijkepersoonByGebruikersAccountId($gebruiker->getGebruikersAccountId());
        if ($persoonLijst) {
            $persoon = new NatuurlijkePersoon($persoonLijst["voornaam"], $persoonLijst["familienaam"]);
        } else {
            $persoonLijst = $this->getRechtspersoonByGebruikersAccountId($gebruiker->getGebruikersAccountId());
            $persoon = new Rechtspersoon($persoonLijst["naam"], $persoonLijst["btwNummer"], (int) $persoonLijst["contactpersoonId"], $persoonLijst["voornaam"], $persoonLijst["familienaam"], $persoonLijst["functie"]);
        }

        $gebruiker->setPersoon($persoon);
        $gebruiker->setKlantId((int) $persoonLijst["klantId"]);

        //ophalen en setten facturatie en leveringsadressen
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("SELECT * FROM klanten WHERE klantId = :klantId");
        $stmt->bindValue(":klantId", $gebruiker->getKlantId());
        $stmt->execute();
        $resultSet = $stmt->fetch(PDO::FETCH_ASSOC);
        $adresDAO = new AdresDAO();
        $gebruiker->setFacturatieAdres($adresDAO->getAdresById((int)$resultSet["facturatieAdresId"]));
        $gebruiker->setLeveringsAdres($adresDAO->getAdresById((int)$resultSet["leveringsAdresId"]));
        $dbh = null;
        setcookie("emailadres", $email, time() + 3600 * 12);
        return $gebruiker;
    }

    public function getNatuurlijkepersoonByGebruikersAccountId($gebruikersAccountId): ?array
    {
        try {
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare("SELECT * FROM natuurlijkepersonen WHERE gebruikersAccountId = :id");
            $stmt->bindValue(":id", $gebruikersAccountId);
            $stmt->execute();
            $resultSet = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$resultSet) return null;
            $array = array("klantId" => $resultSet["klantId"], "voornaam" => $resultSet["voornaam"], "familienaam" => $resultSet["familienaam"]);
            $dbh = null;
            return $array;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    public function getRechtspersoonByGebruikersAccountId($gebruikersAccountId): ?array
    {
        try {

            //ophalen contactpersoon
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare("SELECT * FROM contactpersonen WHERE gebruikersAccountId = :id");
            $stmt->bindValue(":id", $gebruikersAccountId);
            $stmt->execute();
            $resultSet = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$resultSet) return null;
            $lijst = array("klantId" => $resultSet["klantId"], "voornaam" => $resultSet["voornaam"], "familienaam" => $resultSet["familienaam"], "functie" => $resultSet["functie"],  "contactpersoonId" => (int) $resultSet["contactpersoonId"]);


            //ophalen rechtspersoon
            $stmt = $dbh->prepare("SELECT * FROM rechtspersonen WHERE klantId = :id");
            $stmt->bindValue(":id", (int) $lijst["klantId"]);
            $stmt->execute();
            $resultSet = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$resultSet) return null;
            $dbh = null;            
            $lijst["naam"] = $resultSet["naam"];
            $lijst["btwNummer"] = $resultSet["btwNummer"];
            return $lijst;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /*
    public function updategebruiker(gebruiker $gebruiker)
    {

        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("UPDATE gebruikers SET naam = :naam, voornaam = :voornaam, straat = :straat, nummer = :nummer ,plaatsId = :plaatsId, gsm = :gsm , bemerkingen = :bemerkingen WHERE id = :id");
        $stmt->bindValue(":id", $gebruiker->getId());
        $stmt->bindValue(":naam", $gebruiker->getNaam());
        $stmt->bindValue(":voornaam", $gebruiker->getVoornaam());
        $stmt->bindValue(":straat", $gebruiker->getStraat());
        $stmt->bindValue(":nummer", $gebruiker->getNummer());
        $stmt->bindValue(":plaatsId", $gebruiker->getPlaats()->getId());
        $stmt->bindValue(":gsm", $gebruiker->getGsm());
        $stmt->bindValue(":bemerkingen", $gebruiker->getBemerkingen());
        $stmt->execute();
        $laatsteNieuweId = $dbh->lastInsertId();
        $dbh = null;
        $gebruiker->setId($laatsteNieuweId);
        return $gebruiker;
    }
    */
}
