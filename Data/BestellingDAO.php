<?php
//Data/BestellingDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Data\BestellijnDAO;
use DateTime;
use Entities\ActieCode;
use Entities\Bestellijn;
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
}