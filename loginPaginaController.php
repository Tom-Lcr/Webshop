<?php

declare(strict_types=1);

spl_autoload_register();

use Business\WinkelkarService;
use Business\ArtikelService;
//use Business\RecensieService;

session_start();

//require_once("vendor/autoload.php");

use Business\GebruikerService;
use Entities\Gebruiker;
use Entities\NatuurlijkePersoon;
use Entities\Rechtspersoon;
use Exceptions\OngeldigEmailadresException;
use Exceptions\WachtwoordVerkeerdException;
use Exceptions\GebruikerBestaatNietException;

$emailadres = "";
if (isset($_COOKIE["emailadres"])) {
$emailadres = $_COOKIE["emailadres"];
}

$error = "";
try {
    if (isset($_GET["action"])) {
        $email = "";
        $wachtwoord = "";
        $gebruiker = null;
        if (!empty($_POST["txtEmail"])) {
            $email = $_POST["txtEmail"];
        } else {
            $error .= "Het e-mailadres moet ingevuld worden. \n";
        }
        if (!empty($_POST["txtWachtwoord"])) {
            $wachtwoord = $_POST["txtWachtwoord"];
        } else {
            $error .= "Het wachtwoord moet ingevuld worden. \n";
        }
        if ($error == "") {
            $gebruikerSvc = new GebruikerService();
            $gebruiker = $gebruikerSvc->login($email, $wachtwoord);
            $_SESSION["gebruiker"] = serialize($gebruiker);

            header("location: startPagina.php");
            exit(0);
        }
    }
} catch (OngeldigEmailAdresException $e) {
    $error .= "Ongeldig emailadres.\n";
} catch (GebruikerBestaatNietException $e) {
    $error .= "Geen gebruiker met dit emailadres.\n";
} catch (WachtwoordVerkeerdException $e) {
    $error .= "Wachtwoord verkeerd.\n";
}
include("Presentation/loginPagina.php");
