<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Prularia</title>
</head>

<body>

    <header>
        <div class="container">
            <a href="index.php"><img src="../img/logo_prularia_wit.png" alt="logo" id="logo"></a>
            <nav class="menu">
                <a href="#"><img src="../img/winkelkar.png" alt="winkelkar"></a>
                <div class="profielMenu">
                    <a href="#"><img src="../img/profiel.png" alt="profiel"></a>
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
                        <a href="index.php">Filters herstellen</a>
                    </section>
                </form>
            </aside>

            <section class="artikelOverzicht">
                <h1>Aanbevolen producten</h1>
                <!-- placeholders tijdelijk-->
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </article>
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </article>
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </article>
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </article>
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </article>
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </article>
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </article>
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </article>
                <article class="artikel">
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                    <h4>Productnaam</h4>
                    <p>€Productprijs
                    <p>
                    <p class="pBeschikbaarheid">Beschikbaarheid</p>
                    <form action="" class="winkelKarPerArtikelForm">
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
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

</html>