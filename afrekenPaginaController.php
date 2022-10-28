<?php

declare(strict_types=1);

spl_autoload_register();

use Entities\Bestelling;
use Business\WinkelkarService;
use Business\ArtikelService;
use Entities\Winkelkar;
use Business\ActiecodeService;
use Business\BestellingService;
use Entities\NatuurlijkePersoon;
use Entities\Rechtspersoon;
use Exceptions\ActieCodeBestaatNietException;
use Exceptions\ActieCodeNietMeerGeldigException;
use Entities\Bestellijn;

//use Business\RecensieService;

//todo winkelkar unsetten als bestelling geslaagd is

session_start();

$mandje;
$controle = "";


if (!isset($_SESSION["gebruiker"])) {
    header("location: startPagina.php");
    exit(0);
}
$gebruiker = unserialize($_SESSION["gebruiker"]);
//print("<h2>" . $gebruiker->getPersoon()->getNaam() . "</h2>");

if (isset($_SESSION["winkelmand"])) {
    // $mand = unserialize($_SESSION["winkelmand"]);
}

////////////////////////////////////////////////////////////////////////

if (isset($_GET["action"]) && $_GET["action"] === "submit") {
    try {

        if (isset($_POST['controleren'])) {
            $actiecodeInput = $_POST["promo"];
            $controle = !($_POST["promo"]) ? "Geen actiecode" : (((new ActiecodeService())->controleer($_POST["promo"])) ? "Actiecode toegevoegd"  : "foutje");
        }
        //bestellen

        if (isset($_POST['bestellen'])) {
            // print("***********bestelling verwerken***********");
            $bestelling = new Bestelling();
            if ($_POST["promo"] && (new ActiecodeService())->controleer($_POST["promo"])) {
                $actiecodeInput = $_POST["promo"];
                $bestelling->setActiecodeGebruikt(true);
            }
            $bestelling = new Bestelling();
            $bestelling->setKlantId($gebruiker->getKlantId());
            $bestelling->setBetaalwijze($_POST["betaalMethode"]);

            //indien betaalmethode 1 (=kredietkaart )  dan moet status 2(=betaald) zijn
            //indien betaalmethode 2 (=overschrijving )  dan moet status 1(=lopend) zijn
            $bestelling->setBestellingsstatus($_POST["betaalMethode"]) == "1" ? "2" : "1";
            $bestelling->setBetaald($_POST["betaalMethode"] == "1" ? true : false);
            $bestelling->setFacturatieAdres($gebruiker->getFacturatieAdres());
            $bestelling->setLeveringsAdres($gebruiker->getLeveringsAdres());
            if ($gebruiker->getPersoon() instanceof NatuurlijkePersoon) {
                $bestelling->setVoornaam($gebruiker->getPersoon()->getVoornaam());
                $bestelling->setFamilienaam($gebruiker->getPersoon()->getFamielienaam());
            }
            if ($gebruiker->getPersoon() instanceof Rechtspersoon) {
                $bestelling->setVoornaam($gebruiker->getPersoon()->getContactVoornaam());
                $bestelling->setFamilienaam($gebruiker->getPersoon()->getContactFamilienaam());
                $bestelling->setBedrijfsnaam($gebruiker->getNaam());
                $bestelling->setBtwNummer($gebruiker->getPersoon()->getBtwNummer());
            }

            //bestellijnen toevoegen
            //AAN TE PASSEN!!!!!!!!!!!!!!!
            /*
            foreach ($_SESSION["winkelmand"] as $artikel) {
                $bestelling->voegBestellijnToe(new Bestellijn(null, null, $mandje->getArtikelId(), $mandje->getAantal(), 0));    
            }
            */
            $bestelling->voegBestellijnToe(new Bestellijn(null, null, 1, 2, 0));
            $bestelling->voegBestellijnToe(new Bestellijn(null, null, 2, 4, 0));
            
            (new BestellingService())->plaatsBestelling($bestelling); 
            //unset winkelmandje;           
            header("location: startPagina.php");
            exit(0);
        }
    } catch (ActieCodeBestaatNietException) {
        $controle = "Deze code bestaat niet";
        $actiecodeInput = $_POST["promo"];
    } catch (ActieCodeNietMeerGeldigException) {
        $controle = "Deze code is niet meer geldig";
        $actiecodeInput = "";
    }
}

//AAN TE PASSEN
$totaal=100.6;
$aantalArtikelen=3;

include("Presentation/afrekenPagina.php");
