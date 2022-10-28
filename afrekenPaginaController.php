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

session_start();
$controle = "";

if (!isset($_SESSION["gebruiker"])) {
    header("location: startPagina.php");
    exit(0);
}
$gebruiker = unserialize($_SESSION["gebruiker"]);
if (isset($_GET["action"]) && $_GET["action"] === "submit") {
    try {

        if (isset($_POST['controleren'])) {
            $actiecodeInput = $_POST["promo"];
            $controle = !($_POST["promo"]) ? "Geen actiecode" : (((new ActiecodeService())->controleer($_POST["promo"])) ? "Actiecode toegevoegd"  : "foutje");
        }

        //bestellen
        if (isset($_POST['bestellen'])) {
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
            foreach ($_SESSION["winkelmand"] as $artikel) {
                $bestelling->voegBestellijnToe(new Bestellijn(null, null, (unserialize($artikel))->getProductId(), (unserialize($artikel))->getAantal(), 0));
            }

            (new BestellingService())->plaatsBestelling($bestelling);
            unset($_SESSION["winkelmand"]);
            unset($_SESSION["totaalPrijs"]);
            unset($_SESSION["aantalitems"]);
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

$totaal = $_SESSION["totaalPrijs"];
$aantalArtikelen = $_SESSION["aantalitems"];
include("Presentation/afrekenPagina.php");