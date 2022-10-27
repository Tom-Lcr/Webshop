<?php
//Business/GebruikerService.php
declare(strict_types = 1);

namespace Business;

use Data\GebruikerDAO;
use Entities\Gebruiker;


class GebruikerService {
 
   

    public function registreer($familieNaam, $voorNaam, $emailAdres, $paswoord, $herpaswoord, bool $tweeAdressen, bool $isParticulier, $straatNaaml, $huisNummerl, $postcodel, $plaatsNaaml, $straatNaamf = null, int $huisNummerf = null, $postcodef = null, $plaatsNaamf = null, $bedrijfsNaam, $btwNummer, $functie): ?Gebruiker {
        $gebruikerDAO = new GebruikerDAO();
        $gebruiker = $gebruikerDAO->registreer($familieNaam, $voorNaam, $emailAdres, $paswoord, $herpaswoord, (bool) $tweeAdressen, (bool) $isParticulier, $straatNaaml, $huisNummerl, $postcodel, $plaatsNaaml, $straatNaamf, (int) $huisNummerf, $postcodef, $plaatsNaamf, $bedrijfsNaam, $btwNummer, $functie);
        return $gebruiker;
    }
         

    /*
    public function registreerGebruiker(User $user): User
    {
        return ((new UserDAO)->register($user));
    }
*/

/*
    public function controleerGebruiker()
    {
        if (!isset($_SESSION["gebruiker"])) {
            header("Location: login.php?redirect=true");
            exit;
        }
    }

    */
    public function logOut()
    {
        unset($_SESSION["gebruiker"]);
    }

    public function login($email, $paswoord) :?Gebruiker
    {
        return ((new GebruikerDAO)->login($email, $paswoord));
    }

    /*
    public function update(User $user)
    {
        (new UserDAO)->updateUser($user);
    }

    */
}
