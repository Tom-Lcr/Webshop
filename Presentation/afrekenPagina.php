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
                
                                <a href="./bestellingOverzichtPagina.php">Mijn bestellingen</a>
            
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
            <h2>Bestelling plaatsen</h2>
            <section class="afrekenDetails">
                <section class="adres">
                    <h4>Leveringsadres</h4>
                    <p><?php print($gebruiker->getNaam()) ?></p>
                    <p><?php print($gebruiker->getLeveringsAdres()->getStraat() . " " . $gebruiker->getLeveringsAdres()->getHuisNummer()) ?></p>
                    <p><?php print($gebruiker->getLeveringsAdres()->getPlaats()->getPostcode() . " " . $gebruiker->getLeveringsAdres()->getPlaats()->getplaatsNaam()) ?></p>
                </section>
                <br>
                <form action="./afrekenPaginaController.php?action=submit" method="POST" name="afrekenForml">
                    <section class="betaalmethode">
                        <h4> Selecteer een betaalmethode</h4>
                        <br>
                        <select name="betaalMethode" id="">
                            <option value="2">Overschrijving</option>
                            <option value="1" <?php if(($_POST["betaalMethode"] ?? "2") === "1") print("selected") ?> >Kredietkaart</option>
                        </select>
                    </section>
                    <section class="promoCodes">
                        <h4>Promocode invoeren</h4>
                        <br>                        
                            <input type="text" name="promo" value="<?php print($actiecodeInput ?? '') ?>" id="promo">
                            <input type="submit" name="controleren" value="Controleren" id="promoCheck"> <span class="Retour"><?php print($controle)  ?></span>                 
                    </section>
                    <input type="submit" name="bestellen" value="Bestellen" class="button">
                </form>
            </section>

            <aside class="totaalWinkelkar">
                <h4>Overzicht</h4>
                <p><?php print($aantalArtikelen) ?> artikelen</p>
                <p class="totaal">Totaalprijs</p>
                <p class="totaalPrijs">€<?php print($controle ==="Actiecode toegevoegd" ? $totaal*0.9 : $totaal) ?></p>
            </aside>
        </div>
    </main>
    <footer class="cf">
        <div class="container">
            <p>Prularia</p>
        </div>
    </footer>
</body>