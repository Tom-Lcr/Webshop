<?php
//Data/BestellingDAO
declare(strict_types = 1);

namespace Data;



use Entities\ActieCode;
use Entities\Bestellijn;
use DateTime;
use \PDO;
use Data\DBConfig;
use Entities\Bestelling;
use Data\BestellijnDAO;
use Data\AdresDAO;
use Exceptions\ActieCodeBestaatNietException;
use Exceptions\ActieCodeNietMeerGeldigException;
use Exceptions\DatabaseException;
use PDOException;


class BestellingDAO {
 
    public function plaatsBestelling($bestelling)
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $dbh->beginTransaction();
            $stmt = $dbh->prepare(  "insert into bestellingen (besteldatum, klantId, betaald, betalingscode, betaalwijzeId,
                                     annulatie, bestellingsStatusId, actiecodeGebruikt, bedrijfsnaam)
                                     values (now(), :klantId, :betaald, K20221010134533, :betaalwijze, :statusId, :actiecodeGebruikt, :bedrijfsnaam, :btwNummer, :voornaam, :familienaam, :facturatieAdresId, :leveringsAdresId");
            $stmt->bindValue(":klantId", $bestelling->getKlantId());
            
            $stmt->bindValue(":betaald", $bestelling->getBetaald());
            $stmt->bindValue(":betaalwijze", $bestelling->getBetaalwijze);
            
            //status afh van betaalwijze
            $stmt->bindValue(":statusId", $bestelling->getBetaalwijze()===1 ? 2:1);
            $stmt->bindValue(":actiecodeGebruikt", $bestelling->getActiecodeGebruikt());
            $stmt->bindValue(":bedrijfsnaam", $bestelling->getBedrijfsnaam());
            $stmt->bindValue(":btwNummer", $bestelling->getBtwNummer());
            $stmt->bindValue(":voornaam", $bestelling->getVoornaam);
            $stmt->bindValue(":familienaam", $bestelling->getFamilienaam());
            $stmt->bindValue(":facturatieAdresId", $bestelling->getFacturatieAdres()->getAdresId());
            $stmt->bindValue(":leveringsAdresId", $bestelling->getLeveringsAdres()->getAdresId());

            $stmt->execute();
            $bestelId = (int) $dbh->lastInsertId();
            $lijnDAO = new BestellijnDAO();
            
            foreach ($bestelling->getBestellijnen as $bestellijn) {
                if ($bestellijn->getAantalBesteld() > 0) {
                    $lijnDAO->voegBestelRegelToe($bestellijn, $dbh);
                }
            }

            $dbh->commit();
        } catch (PDOException $e) {
 
            print('mislukt');
            print "Error!: " . $e->getMessage() . "<br/>";
            $dbh->rollBack();
        }
    }
    
    public function getBestellingenByKlantId(int $klantId) : array {
        $sql = "select * from bestellingen where klantId = :klantId;";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':klantId' => $klantId));
        $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lijst = array();
        foreach($resultSet as $rij){
            $besteldatum = new DateTime($rij["besteldatum"]);
            $bestellijndao = new BestellijnDAO;
            $bestellijnen = $bestellijndao->getBestellijnenByBestelId((int)$rij["bestelId"]);
            $adresdao = new AdresDAO;
            $facturatieadres = $adresdao->getAdresById((int)$rij["facturatieAdresId"]);
            $leveringadres = $adresdao->getAdresById((int)$rij["leveringsAdresId"]); 
            $betaalwijzeId = intval($rij["betaalwijzeId"]);
            if ($betaalwijzeId === 1) {
                $betaalwijze = "Kredietkaart";
            } else {
                $betaalwijze = "Overschrijving";
            }
            $bestellingsStatusId = intval($rij["bestellingsStatusId"]);
            switch ($bestellingsStatusId) {
                case 1:
                    $bestellingsStatus = "Lopend";
                    break;
                case 2:
                    $bestellingsStatus = "Betaald";
                    break;
                case 3:
                    $bestellingsStatus = "Geannuleerd";
                    break;
                case 4:
                    $bestellingsStatus = "Klaarmaken";
                    break;
                case 5:
                    $bestellingsStatus = "Onderweg";
                    break;
                case 6:
                    $bestellingsStatus = "Geleverd";
                    break;
                case 7:
                    $bestellingsStatus = "Verloren";
                    break;
                case 8:
                    $bestellingsStatus = "Beschadigd";
                    break;
                case 9:
                    $bestellingsStatus = "Retour";
                    break;
                case 10:
                    $bestellingsStatus = "Retour in stock";
                    break;                                         
            }
            $bestelling = new Bestelling((int)$rij["bestelId"], $besteldatum, (int)$rij["klantId"], 
            (bool)$rij["betaald"], $rij["betalingscode"], $betaalwijze, (bool)$rij["annulatie"], $rij["terugbetalingscode"],
            $bestellingsStatus, (bool)$rij["actiecodeGebruikt"], $rij["bedrijfsnaam"], $rij["btwNummer"], $rij["voornaam"],
            $rij["familienaam"], $facturatieadres, $leveringadres, $bestellijnen);
            array_push($lijst, $bestelling);
        }		
        $dbh = null;
        return $lijst;
        }
    
   
}