<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>bestellingOverzichtPagina</title>
</head>

<body>

    <header>
        <div class="container">
            <a href="startPagina.php"><img src="img/logo_prularia_wit.png" alt="logo" id="logo"></a>
            <nav class="menu">
                <div class="menuOpties">
                    <div class="profielMenu">
                        <a href="#"><img src="img/profiel.png" alt="profiel"></a>
                        <div class="dropdown" id="myDropdown">
                            <a href="#" id="menu">MENU</a>
                            <div class="dropdown-content">
                                <a href="#">Mijn profiel</a>

                                <a href="./bestellingenOverzichtPaginaController.php">Mijn bestellingen</a>

                                <a href="./winkelKarPaginaController.php">Winkelkar</a>
                            </div>
                        </div>

                    </div>
                    <a href="#"><img src="img/winkelkar.png" alt="winkelkar"></a>
                    <!-- Dit is de badge die bij het winkelkarretje aanduidt hoeveel items erin zitten. Het getal vijf is hier placeholder, 
                    hier moet de code komen die het aantal weergeeft -->
                    <?php
                    if (isset($_SESSION["aantalitems"])) {

                    ?>
                        <?php // print count($_SESSION["winkelmand"]); 
                        ?>
                        <span class='badge badge-warning' id='lblCartCount'> <?php print $_SESSION["aantalitems"]; ?> </span>
                    <?php
                    }
                    ?>
                    <!--  <span class='badge badge-warning' id='lblCartCount'> 0 </span> -->
                    <?php
                    //}
                    ?>
                </div>
            </nav>
        </div>

    </header>

    <main>
        <div class="container paginaSmal">


            <h1>Bestellingen</h1>
            <?php
            foreach ($bestellingLijst as $bestelling) {
            ?>
                <section class="bestellingDetails">
                    <br>
                    <h3>Bestelnummer: <?php echo $bestelling->getBestelId(); ?> </h3>
                    <h3 class="datum"><?php print $bestelling->getBesteldatum(); ?></h3>
                    <section class="bestelAdres">
                        <h5>Facturatieadres:</h5><br>
                        <p>Straat: <?php print $bestelling->getFacturatieAdres()->getStraat(); ?></p>
                        <p>Huisnummer: <?php print $bestelling->getFacturatieAdres()->getHuisNummer(); ?></p>
                        <p>Postcode: <?php print $bestelling->getFacturatieAdres()->getPlaats()->getPostcode(); ?></p>
                        <p>Plaats: <?php print $bestelling->getFacturatieAdres()->getPlaats()->getPlaatsNaam(); ?></p>
                    </section>
                    <section class="bestelAdres">
                        <h5>Leveradres:</h5><br>
                        <p>Straat: <?php print $bestelling->getLeveringsAdres()->getStraat(); ?></p>
                        <p>Huisnummer: <?php print $bestelling->getLeveringsAdres()->getHuisnummer(); ?></p>
                        <p>Postcode: <?php print $bestelling->getLeveringsAdres()->getPlaats()->getPostcode(); ?></p>
                        <p>Plaats: <?php print $bestelling->getLeveringsAdres()->getPlaats()->getPlaatsNaam(); ?></p>
                    </section>
                    <br>
                    <h5>Betaald:</h5><br>
                    <?php if ($bestelling->getBetaald() === 1) { ?>
                        <p>Ja</p>
                    <?php } else { ?>
                        <p>Nee</p>
                    <?php } ?>
                    <br>
                    <h5>Betaalwijze:</h5><br>
                    <p><?php print $bestelling->getBetaalwijze(); ?></p>
                    <br>
                    <h5>Bestellingsstatus:</h5><br>
                    <p><?php print $bestelling->getBestellingsStatus(); ?></p>
                <?php } ?>
                <br>
                </section>
                <br>
                <h3>Artikeloverzicht:</h3>
                <?php
                foreach ($bestellijnen as $bestellijn) {
                ?>
                    <article class="winkelkarLijn">
                        <img src="img/<?php echo $artikelSvc->getArtikelById($bestellijn->getArtikelId())->getNaam(); ?>.png" alt="Productfoto" class="artikelInKar">
                        <div class="details bestelDetails">
                            <h4 class="artikelTitel">
                                <?php print $artikelSvc->getArtikelById($bestellijn->getArtikelId())->getNaam(); ?>
                            </h4>
                            <p class="prijs">€<?php print $artikelSvc->getArtikelById($bestellijn->getArtikelId())->getPrijs(); ?></p>
                            <p><?php print $bestellijn->getAantalBesteld(); ?> besteld</p>
                        </div>
                    </article>

                <?php } ?>

        </div>

    </main>
    <footer class="cf">
        <div class="container">
            <p>Prularia</p>
        </div>
    </footer>
</body>

</html>