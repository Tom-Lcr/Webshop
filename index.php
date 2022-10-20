<?php

declare(strict_types=1);

spl_autoload_register();

use Business\CategorieService;
use Data\ArtikelDAO;
use Entities\Artikel;

$categorieService = new CategorieService;
//$lijst = $categorieService->getAllCategorieIdsByCategorieID(1);
$lijst = (new ArtikelDAO)->getAll(1);
//$lijst = $categorieService->getSubcategorieIdsById(3);

//print_r($lijst2);
print('<br>');
print('<hr>');
print('<br>');
print(count($lijst));
print('<br>');
print('<hr>');
print('<br>');
foreach ($lijst as $key => $value) {
    print($value->getNaam() . " =>" .  $value->getRating() . " -  " .  $value->getPrijs() . "<br>");
    //print_r($value);
    //print('br');
}
