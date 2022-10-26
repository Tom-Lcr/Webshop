<?php
//Data/GebruikerDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Data\AdresDAO;
use Data\PersoonDAO;
use Entities\Gebruiker;
use Entities\Adres;
use Entities\Persoon;
use Exceptions\GebruikerBestaatAlException;
use Exceptions\OngeldigEmailadresException;
use Exceptions\WachtwoordenKomenNietOvereenException;


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

    public function emailReedsInGebruik($emailAdres): int
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("SELECT * FROM gebruikersaccounts WHERE emailadres = :emailadres");
        $stmt->bindValue(":emailadres", $emailAdres);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        $dbh = null;
        return $rowCount;
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

}