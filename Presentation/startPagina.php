<?php
    declare(strict_types=1);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset=utf-8>
    <title>Prularia</title>
    <style>
        article{
            display: inline-block;
            border-style: solid;
        }

        form, p, img, input, h4 {
           display: inline;
        }
    </style>
</head>
<body>
   <section class="artikelOverzicht">
    <h1>Artikel Overzicht</h1>
    <?php 
            $teller = 0;  
            foreach ($artikelLijst as $artikel) {
                $teller++;
    ?> 
            <article class="artikel">
            <form method="post" action="./startPagina.php?action=voegToe&id=<?php print($artikel->getArtikelId());?>">
                    <img src="../img/dummy.avif" alt="" class="productFoto"><br>
                    <h4><?php print $artikel->getNaam(); ?></h4><br>
                    <p>€<?php print $artikel->getPrijs(); ?><br>
                    <p><br>
                    <?php if ($artikel->isInVoorraad()) { ?>    
                    <p class="pBeschikbaarheid">In voorraad</p><br>
                    <?php }else{ ?> 
                    <p class="pBeschikbaarheid">Niet beschikbaar</p><br> 
                    <?php } ?>
                    <input type="number" name="nmbAantal" size="4" />&nbsp;
                    <input type="submit" value="Toevoegen" />
                    </form><br>  
                </article>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php 
                if ($teller === 4) { 
                    print "<br><br>";
                    $teller = 0;
                 }
                } 
                ?>
                <br>
                
                
    </section> 
      <?php   
            if ($pagina > 1) {
                print '<a href="./startPagina.php?page=' . ($pagina - 1) . '">' . "<=" . '</a> '; 
            }
            for($paginaT=1;$paginaT<=$aantalPaginas;$paginaT++){
                if ($pagina === $paginaT) {
                print '<a href="./startPagina.php?page=' . $paginaT . '">' . $paginaT . '</a> ';
                }else{
                print '<a href="./startPagina.php?page=' . $paginaT . '">' . $paginaT . '</a> ';    
                }
            }
            if ($pagina < $aantalPaginas) {
                print '<a href="./startPagina.php?page=' . ($pagina + 1) . '">' . "=>" . '</a> '; 
            }
            ?>     
</body>
</html> 