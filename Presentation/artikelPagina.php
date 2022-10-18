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

    <main>
        <div class="container artikelSpecifiek">
            <article>
                <section class="artikelHeader">
                    <h2>Artikelnaam</h2>
                    <img src="../img/dummy.avif" alt="" class="productFoto">
                </section>
                <aside class="artikelSpecifiekeOpties">
                    <h2>€129,99</h2>
                    <p>11 stuks in voorraad</p>
                    <form action="" class="winkelKarSpecifiekArtikelform">
                        <label for="aantalVanArtikel">Aantal:</label>
                        <br>
                        <input type="number" name="" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="../img/winkelkar.png" alt=""></button>
                    </form>
                </aside>
                <section class="artikelBeschrijving cf">
                    <h3>Productbeschrijving</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo beatae nihil neque voluptatibus nemo nisi officia, laudantium excepturi fugit quasi asperiores, consequuntur eos, incidunt ipsum omnis quam ab ut aspernatur. Quam sapiente ad iure quos. Dolorem aliquam vitae eligendi vel. Numquam ea provident sint natus ullam eveniet inventore necessitatibus iusto.</p>
                </section>
                <section class="score">
                   <h3>Gemiddelde waardering</h3>
                   <p class="score">3,3</p>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </section>
                <section class="gebruikersreviews">
                    <h3>Reviews</h3>
                    
                </section>
            </article>

        </div>
    </main>
    <footer class="cf">
        <div class="container">
            <p>Prularia</p>
        </div>
    </footer>
</body>

</html>