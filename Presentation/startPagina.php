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

    <title>Prularia</title>
</head>

<body>

    <header>
        <div class="container">
            <a href="Presentation/startPagina.php"><img src="img/logo_prularia_wit.png" alt="logo" id="logo"></a>
            <nav class="menu">
                <a href="#"><img src="img/winkelkar.png" alt="winkelkar"></a>
                <div class="profielMenu">
                    <a href="#"><img src="img/profiel.png" alt="profiel"></a>
                    <a href="#" id="menu">MENU</a>
                </div>
            </nav>
        </div>
    </header>

    <section class="zoekSectie">
        <div class="container">
            <div class="zoeken">
                <form action="" method="post" id="zoekForm">
                    <input type="text" placeholder="Zoeken.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </section>

    <main class="clearFix">

        <div class="container clearFix">

            <aside class="filterOpties">
                <form action="" method="post" name="filter">
                    <h2>Opties</h2>
                    <section>
                        <h3>Sorteren op:</h3>
                        <select name="sorteerOpties" id="" class="sorteerOpties">
                            <option value="">Waardering - hoog</option>
                            <option value="">Waardering - laag</option>
                            <option value="">Prijs - hoog</option>
                            <option value="">Prijs - laag</option>
                        </select>
                        <h3>Categorie:</h3>
                        <select name="categorieOpties" id="" class="categorieOpties">
                            <option value="">categorieen</option>
                        </select>
                        <h3>Beschikbaarheid:</h3>
                        <input type="checkbox" name="checkBeschikbaarheid" value="nuBeschikbaar">
                        <label for="checkBeschikbaarheid">Nu beschikbaar</label>
                        <h3>Waardering:</h3>
                        <input type="checkbox" name="checkRecencie">
                        <label for="checkRecensie">Artikelen met een recencie</label>
                        <br>
                        <input type="checkbox" name="checkZonderRecensie">
                        <label for="checkZonderRecensie">Zonder recensie (Be first to buy)</label>
                        <br>
                        <input type="submit" value="Filteren" class="button">
                        <br>
                        <a href="Presentation/startPagina.php">Filters herstellen</a>
                    </section>
                </form>
            </aside>

            <section class="artikelOverzicht">
                <h1>Aanbevolen producten</h1>
                <!-- placeholders tijdelijk-->
                <section class="producten clearFix">
                <?php
                $teller = 0;
                foreach ($artikelLijst as $artikel) {
                    $teller++;
                ?>
                    <article class="artikel">
                        <img src="img/dummy.avif" alt="" class="productFoto">
                        <h4><?php print $artikel->getNaam(); ?></h4>
                        <p>€<?php print $artikel->getPrijs(); ?>
                        <p>
                            <?php if ($artikel->isInVoorraad()) { ?>
                        <p class="pBeschikbaarheid">In voorraad</p>
                    <?php } else { ?>
                        <p class="pBeschikbaarheid">Niet beschikbaar</p>
                    <?php } ?>
                    <form method="post" action="./startPagina.php?action=voegToe&id=<?php print($artikel->getArtikelId()); ?>" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="img/winkelkar.png" alt=""></button>
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
                    for ($paginaT = 1; $paginaT <= $aantalPaginas; $paginaT++) {
                        if ($pagina === $paginaT) {
                            print '<a href="./startPagina.php?page=' . $paginaT . '">' . $paginaT . '</a> ';
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