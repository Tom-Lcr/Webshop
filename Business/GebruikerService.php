<?php
//Business/UserService.php
declare(strict_types=1);

namespace Business;
use Entities\Gebruiker;
use Data\GebruikerDAO;

class GebruikerService
{
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
