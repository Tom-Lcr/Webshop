<?php
//Data/BestellingDAO
declare(strict_types = 1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Bestelling;
use Data\BestellijnDAO;
use Data\AdresDAO;


class BestellingDAO {

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
            $facturatieadres = $adresdao->getAdresByAdresId((int)$rij["facturatieAdresId"]);
            $leveringadres = $adresdao->getAdresByAdresId((int)$rij["leveringAdresId"]); 
            $betaalwijzeId = intval($rij["betaalwijzeId"]);
            if ($betaalwijzeId === 1) {
                $betaalwijze = "Kredietkaart";
            } else {
                $betaalwijze = "Overschrijving";
            }
            $bestellingsStatusId = intval($rij["bestellingsStatuseId"]);
            switch ($bestellingsStatusId) {
                case 1:
                    $bestellingsStatus = "Lopend";
                    return $bestellingsStatus;
                    break;
                case 2:
                    $bestellingsStatus = "Betaald";
                    return $bestellingsStatus;
                    break;
                case 3:
                    $bestellingsStatus = "Geannuleerd";
                    return $bestellingsStatus;
                    break;
                case 4:
                    $bestellingsStatus = "Klaarmaken";
                    return $bestellingsStatus;
                    break;
                case 5:
                    $bestellingsStatus = "Onderweg";
                    return $bestellingsStatus;
                    break;
                case 6:
                    $bestellingsStatus = "Geleverd";
                    return $bestellingsStatus;
                    break;
                case 7:
                    $bestellingsStatus = "Verloren";
                    return $bestellingsStatus;
                    break;
                case 8:
                    $bestellingsStatus = "Beschadigd";
                    return $bestellingsStatus;
                    break;
                case 9:
                    $bestellingsStatus = "Retour";
                    return $bestellingsStatus;
                    break;
                case 10:
                    $bestellingsStatus = "Retour in stock";
                    return $bestellingsStatus;
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
    
