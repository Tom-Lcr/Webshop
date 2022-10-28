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
        <div class="container">
            <section class="registerForm">

                <h2>Registratie</h2>
                <form action="" name="registratieForm">
                    <input type="button" value="Particulier" class="button links">
                    <input type="button" value="Professioneel" class="button rechts">
                    <br>
                    <label for="txtNaam">Naam</label>
                    <input type="text" name="txtNaam" id="" required>
                    <br>
                    <label for="txtVoornaam">Voornaam</label>
                    <input type="text" name="txtVoornaam" id="" required>
                    <br>
                    <label for="txtEmail">E-mailadres</label>
                    <input type="email" name="txtEmail" id="" required>
                    <br>
                    <label for="txtWachtwoord">Wachtwoord</label>
                    <input type="text" name="txtWachtwoord" id="" required>
                    <br>
                    <label for="txtWachtwoordHerhaling">Wachtwoord herhaling</label>
                    <input type="text" name="txtWachtwoordHerhaling" id="" required>
                    <br>
                    <section class="adres">
                        <br>
                        <div class="adresInput">
                            <h4>Leveringsadres</h4>
                            <br>
                            <label for="txtStraat">Straatnaam</label>
                            <input type="text" name="txtStraat" id="" required>
                            <br>
                            <label for="nmbHuisnummer">Huisnummer</label>
                            <input type="number" name="nmbHuisnummer" id="" required>
                            <br>
                            <label for="txtBus">Bus</label>
                            <input type="text" name="txtBus" id="">
                            <br>
                            <label for="txtPostcode">Postcode</label>
                            <input type="text" name="txtPostcode" id="" required>
                            <br>
                            <label for="txtPlaats">Plaatsnaam</label>
                            <input type="text" name="txtPlaats" id="plaatsNaam" required>
                        </div>
                    </section>
                    <section class="adres">
                        <br>
                        <div class="adresInput">
                            <h4>Facturatiesadres (optioneel)</h4>
                            <br>
                            <label for="txtStraat">Straatnaam</label>
                            <input type="text" name="txtStraat" id="" required>
                            <br>
                            <label for="nmbHuisnummer">Huisnummer</label>
                            <input type="number" name="nmbHuisnummer" id="" required>
                            <br>
                            <label for="txtBus">Bus</label>
                            <input type="text" name="txtBus" id="">
                            <br>
                            <label for="txtPostcode">Postcode</label>
                            <input type="text" name="txtPostcode" id="" required>
                            <br>
                            <label for="txtPlaats">Plaatsnaam</label>
                            <input type="text" name="txtPlaats" id="plaatsNaam" required>
                        </div>
                    </section>
                    <br>
                    <label for="txtBTW">BTW-nummmer (optioneel)</label>
                    <input type="text" name="txtBTW" id="">
                    <br>
                    <label for="txtBedrijfsNaam">Bedrijfsnaam (optioneel)</label>
                    <input type="text" name="txtBedrijfsNaam" id="">
                    <br>
                    <input type="submit" value="Registreren" class="button register">
                </form>
            </section>
        </div>
    </main>
    <footer class="cf">
        <div class="container">
            <p>Prularia</p>
        </div>
    </footer>
</body>