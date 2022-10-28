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
    <title>Prularia</title>
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
            <a href="" class="verderWinkelen">
                < Alle bestellingen</a>
                    <section class="bestellingDetails">
                        <h2>Bestelling</h2>
                        <h4>Bestellingsnummer:</h4>
                        <p>13244</p>
                        <h4>Klantnummer:</h4>
                        <p>1478</p>
                        <h4>Leveringsadres:</h4>
                        <p>Alexander Le Grande</p>
                        <p>Macedoniëplein 14</p>
                        <p>9000 Gent</p>
                        <h4>Datum van bestelling</h4>
                        <p>2022-10-03</p>
                        <h4>Status van de bestelling:</h4>
                        <p>Geleverd</p>
                    </section>

                    <article class="winkelkarLijn">
                        <img src="img/dummy.avif" alt="Productfoto" class="artikelInKar">
                        <div class="details bestelDetails">
                            <h4 class="artikelTitel">Artikelnaam</h4>
                            <p class="prijs">€99,99</p>
                            <p>2 besteld</p>
                        </div>
                    </article>
                    <article class="winkelkarLijn">
                        <img src="img/dummy.avif" alt="Productfoto" class="artikelInKar">
                        <div class="details bestelDetails">
                            <h4 class="artikelTitel">Artikelnaam</h4>
                            <p class="prijs">€99,99</p>
                            <p>2 besteld</p>
                        </div>
                    </article>
                    <article class="winkelkarLijn">
                        <img src="img/dummy.avif" alt="Productfoto" class="artikelInKar">
                        <div class="details bestelDetails">
                            <h4 class="artikelTitel">Artikelnaam</h4>
                            <p class="prijs">€99,99</p>
                            <p>2 besteld</p>
                        </div>
                    </article>
        </div>
    </main>
    <footer class="cf">
        <div class="container">
            <p>Prularia</p>
        </div>
    </footer>

</body>