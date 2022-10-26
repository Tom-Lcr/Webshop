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

            <section class="bestellingOverzicht">
            <?php
          if($error){
        ?>                  
                    <p class="text-danger"><?php echo $error; ?></p>

        <?php
          }
        ?> 
                <h1>Bestellingen</h1>
                <!-- placeholders tijdelijk-->
                <section class="bestellingen clearFix">
                    <?php
                    foreach ($bestellingLijst as $bestelling) {
                    ?>
                            <h3 class="datum"><?php print $bestelling->getBesteldatum(); ?></h3>
                            <h5>Facturatieadres:</h5><br>
                            <p>Straat:<?php print $bestelling->getFacturatieAdres()->getStraat(); ?></p>
                            <p>Huisnummer:<?php print $bestelling->getFacturatieAdres()->getHuisnummer(); ?></p>
                            <p>Postcode:<?php print $bestelling->getFacturatieAdres()->getPlaats()->getPostcode(); ?></p>
                            <p>Plaats:<?php print $bestelling->getFacturatieAdres()->getPlaats()->getPlaatsNaam(); ?></p>
                            <br>
                            <h5>Leveradres:</h5><br>
                            <p>Straat:<?php print $bestelling->getLeveringsAdres()->getStraat(); ?></p>
                            <p>Huisnummer:<?php print $bestelling->getLeveringsAdres()->getHuisnummer(); ?></p>
                            <p>Postcode:<?php print $bestelling->getLeveringsAdres()->getPlaats()->getPostcode(); ?></p>
                            <p>Plaats:<?php print $bestelling->getLeveringsAdres()->getPlaats()->getPlaatsNaam(); ?></p>
                            <br>
                            <h5>Betaald:</h5>
                            <?php if ($bestelling->getBetaald() === 1) {?>
                                <p>Ja</p>
                            <?php } else {?>
                                <p>Nee</p>
                            <?php } ?>   
                            <br>
                            <h5>Status:</h5><p><?php print $bestelling->getBestellingsStatus(); ?></p>
                            
                            
                            <p><?php print ($artikel->getRating() == 0 ? "Geen rating" : "Rating:" . $artikel->getRating()); ?><p>    
                                <?php if($inVoorraad){
                                    ?> <p class="pBeschikbaarheid">In voorraad</p> <?php }
                                    else{
                                        ?> <p class="pBeschikbaarheid">Niet Beschikbaar</p><?php
                                    }
                                ?>
                            <form method="post" action="./startPagina.php?action=voegToe&id=<?php print($artikel->getArtikelId()); ?>" class="winkelKarPerArtikelForm">
                                <input type="number" name="aantalVanArtikel" id="aantalVanArtikel" min="1" required>
                                <button type="submit" class="winkelkarArtikelBtn" name="btnWinkelKar"><img src="img/winkelkar.png" alt=""></button>
                            </form>
                        </article>

                    <?php
                        if ($teller === 4) {
                            print "<br><br>";
                            $teller = 0;
                        }
                    }
                    ?>
                </section>
                <br>
                <div class="paginaCounter">
                    <?php
                    if ($pagina > 1) {
                        print '<a  href="./startPagina.php?page=' . ($pagina - 1) . '">' . "<=" . '</a> ';
                    }
                    if (!isset($_GET["page"])) {
                        $_GET["page"] = 1;
                    }
                    for ($paginaT = 1; $paginaT <= $aantalPaginas; $paginaT++) {
                        if ((int) $_GET["page"] === $paginaT) {
                            print '<a href="./startPagina.php?page=' . $paginaT . '" class="huidigePagina">' . $paginaT . '</a> ';
                        } else {
                            print '<a href="./startPagina.php?page=' . $paginaT . '">' . $paginaT . '</a> ';
                        }
                    }
                    if ($pagina < $aantalPaginas) {
                        print '<a href="./startPagina.php?page=' . ($pagina + 1) . '">' . "=>" . '</a> ';
                    }
                    ?>
                </div>
            </section>

        </div>
    </main>

    <footer class="cf">
        <div class="container">
            <p>Prularia</p>
        </div>
    </footer>
</body>

</html>