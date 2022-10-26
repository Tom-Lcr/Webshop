<?php
//Business/GebruikerService.php
declare(strict_types = 1);

namespace Business;

use Data\GebruikerDAO;
use Entities\Gebruiker;


class GebruikerService {
 
   

    public function registreer($familieNaam, $voorNaam, $emailAdres, $paswoord, $herpaswoord, bool $tweeAdressen, bool $isParticulier, $straatNaaml, int $huisNummerl, $postcodel, $plaatsNaaml, $straatNaamf = null, int $huisNummerf = null, $postcodef = null, $plaatsNaamf = null, $bedrijfsNaam, $btwNummer, $functie): ?Gebruiker {
        $gebruikerDAO = new GebruikerDAO();
        $gebruiker = $gebruikerDAO->registreer($familieNaam, $voorNaam, $emailAdres, $paswoord, $herpaswoord, (bool) $tweeAdressen, (bool) $isParticulier, $straatNaaml, (int) $huisNummerl, $postcodel, $plaatsNaaml, $straatNaamf, (int) $huisNummerf, $postcodef, $plaatsNaamf, $bedrijfsNaam, $btwNummer, $functie);
        return $gebruiker;
    }
         
} 


