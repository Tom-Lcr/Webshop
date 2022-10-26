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

                              
                
                <h1>Bestellingen</h1>
                    <?php
                    foreach ($bestellingLijst as $bestelling) {
                    ?>
                            <h3 class="datum"><?php print $bestelling->getBesteldatum(); ?></h3>
                            <h5>Facturatieadres:</h5><br>
                            <p>Straat: <?php print $bestelling->getFacturatieAdres()->getStraat(); ?></p>
                            <p>Huisnummer: <?php print $bestelling->getFacturatieAdres()->getHuisNummer(); ?></p>
                            <p>Postcode: <?php print $bestelling->getFacturatieAdres()->getPlaats()->getPostcode(); ?></p>
                            <p>Plaats: <?php print $bestelling->getFacturatieAdres()->getPlaats()->getPlaatsNaam(); ?></p>
                            <br>
                            <h5>Leveradres:</h5><br>
                            <p>Straat: <?php print $bestelling->getLeveringsAdres()->getStraat(); ?></p>
                            <p>Huisnummer: <?php print $bestelling->getLeveringsAdres()->getHuisnummer(); ?></p>
                            <p>Postcode: <?php print $bestelling->getLeveringsAdres()->getPlaats()->getPostcode(); ?></p>
                            <p>Plaats: <?php print $bestelling->getLeveringsAdres()->getPlaats()->getPlaatsNaam(); ?></p>
                            <br>
                            <h5>Betaald:</h5><br> 
                            <?php if ($bestelling->getBetaald() === 1) {?>
                                <p>Ja</p>
                            <?php } else {?>
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
                            <h5>Artikeloverzicht:</h5><br>
                            <?php
                              foreach ($bestellijnen as $bestellijn) {
                             ?>
                             <p><?php print $bestellijn->getAantalBesteld(); ?>x 
                             <?php print $artikelSvc->getArtikelById($bestellijn->getArtikelId())->getNaam(); ?></p>

                             <?php } ?>
                            
    <footer class="cf">
        <div class="container">
            <p>Prularia</p>
        </div>
    </footer>
</body>

</html>