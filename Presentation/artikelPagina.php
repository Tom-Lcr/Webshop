<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <a href="./winkelKarPaginaController.php"><img src="img/winkelkar.png" alt="winkelkar"></a>
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
    <?php
          if($error){
        ?>                  
                    <p class="text-danger"><?php echo $error; ?></p>

        <?php
          }
        ?> 
        <div class="container artikelSpecifiek">
            <article>
                <section class="artikelHeader">
                    <h2><?php print $gekozenArtikel->getNaam(); ?></h2>
                    <img src="img/dummy.avif" alt="" class="productFoto">
                </section>
                <aside class="artikelSpecifiekeOpties">
                    <h2>€<?php print $gekozenArtikel->getPrijs(); ?></h2>
                    <p><?php print $gekozenArtikel->getVoorraad(); ?> stuks in voorraad</p>

                    <!--aantal en artikel id via de url (GET) meegeven aan de controller -->
                    <form action="artikelPaginaController.php?action=voegToe&productId=<?php print(isset($_GET["productId"]) ? $_GET["productId"] : 0); ?>" method="POST" class="winkelKarSpecifiekArtikelform">
                        <label for="aantalVanArtikel">Aantal:</label>
                        <br>
                        <input type="number" name="aantalVanArtikel" id="aantalVanArtikel">
                        <button type="submit" class="winkelkarArtikelBtn"><img src="img/winkelkar.png" alt=""></button>
                    </form>
                </aside>
                <section class="artikelBeschrijving cf">
                    <h3>Productbeschrijving</h3>
                    <p><?php print $gekozenArtikel->getBeschrijving(); ?></p>
                </section>
                <section class="score">
                    <h3>Gemiddelde waardering</h3>
                    <p class="scoreGem"><?php print $gekozenArtikel->getRating(); ?></p>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </section>
                <br>
                <section class="gebruikersreviews">
                    <h3>Reviews</h3>
                    <article>
                        <h4>Klant 1</h4>
                        <p class="datum">10-10-2022</p>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <p class="review">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut magni ratione vero nemo quisquam, sunt sed veniam architecto illum ullam, ipsum iure tempora. Fugiat, quidem.</p>
                    </article>
                    <article>
                        <h4>Klant 2</h4>
                        <p class="datum">10-10-2022</p>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <p class="review">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos, voluptas.</p>
                    </article>
                    <article>
                        <h4>Klant 3</h4>
                        <p class="datum">10-10-2022</p>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <p class="review">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut magni ratione vero nemo quisquam, sunt sed veniam architecto illum ullam, ipsum iure tempora. Fugiat, quidem.</p>
                    </article>
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