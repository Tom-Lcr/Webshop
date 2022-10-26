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
                            <div class="dropdown-content" >
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
            <h2>Mijn Bestellingen</h2>
            <section class="bestellingenOverzicht">


            <!-- voor elke bestellingsstatus heb ik een css klasse gemaakt zodat de verschillende statussen een kleur krijgen, dus de class van de staus paragraaf moet worden gevudl met de status van het bestellingsobject-->
                <article class="bestellingenLijn">
                    <div class="details">
                        <h4 class="artikelTitel">Artikelnaam</h4>
                        <p class="Betaald">Lopend</p>
                    </div>
                </article>
                <article class="bestellingenLijn">
                    <div class="details">
                        <h4 class="artikelTitel">Artikelnaam</h4>
                        <p class="Geannuleerd">Geannuleerd</p>
                    </div>
                </article>
                <article class="bestellingenLijn">
                    <div class="details">
                        <h4 class="artikelTitel">Artikelnaam</h4>
                        <p class="Onderweg">Onderweg</p>
                    </div>
                </article>
                <article class="bestellingenLijn">
                    <div class="details">
                        <h4 class="artikelTitel">Artikelnaam</h4>
                        <p class="Geleverd">Geleverd</p>
                    </div>
                </article
                    <div class="details">
                        <h4 class="artikelTitel">Artikelnaam</h4>
                        <p class="Geleverd">Geleverd</p>
                    </div>
                </article>
            </section>
        </div>
    </main>
    <footer class="cf">
        <div class="container">
            <p>Prularia</p>
        </div>
    </footer>

</body>