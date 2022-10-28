<?php
//Business/BestellingService.php
declare(strict_types = 1);

namespace Business;

use Data\BestellingDAO;
use Entities\Bestellingen;


class BestellingService {
 
   

    public function getBestellingOverzicht(int $klantId) : array {
        $bestellingDAO = new BestellingDAO();
        $lijst = $bestellingDAO->getBestellingenByKlantId((int) $klantId);
        return $lijst;
    }

    public function plaatsBestelling($bestelling)
    {
        (new BestellingDAO())->plaatsBestelling($bestelling);
    }
         
} 
