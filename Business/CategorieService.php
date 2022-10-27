<?php
//Business/CategorieService.php
declare(strict_types=1);

namespace Business;

use Data\CategorieDAO2;

//ieder artikel heeft slechts 1 (of geen) hoofdcategorie
//veronderstelling ivm de database:
//Een artikel kan meerdere categoriën hebben (anders zou geen aparte tabel nodig zijn)
//Als gefilterd wordt op een categorie moeten ook alle subcategorieën meegegeven worden in de query,
//aangezien een artikel niet (noodzakelijk) in de database ook tot de hoofdcategorie zal behoren

class CategorieService
{
    //haalt een lijst van alle categorieën op uit de database
    public function getAlleCategorieën()
    {
        $categorieDAO = new CategorieDAO();
        return $categorieDAO->getAllCategorieen();
    }

    public function getCategorieById(?int $id)
    {

        if($id=== null) return null;
        $categorieDAO = new CategorieDAO();
        $categorie = $categorieDAO->getCategorieById($id);
        return $categorie;
    }

    public function getHoofdcategorieën()
    {
        $categorieDAO = new CategorieDAO();
        return $categorieDAO->getHoofdcategorieen();
    }


    //geeft alle categorieën weer die zich 1 niveau onder het hoofdCategorieId bevinden
    public function getSubcategorieenById(?int $hoofdCategorieId): ?array
    {
        if ($hoofdCategorieId === null) {
            return $this->getHoofdcategorieën();
        }
        $categorieDAO = new CategorieDAO();
        return $categorieDAO->getSubcategorieen($hoofdCategorieId);
    }

    //geeft lijst id's alle subcategorieën (1 niveau lager) weer
    //geeft enkel ids weer aangezien deze nodig zijn in filter query, kan eenvoudig aangepast worden om categorie objecten weer te geven
    public function getSubcategorieIdsById(int $categorieId): ?array
    {
        //hieronder voor als lijst categorieën wordt meegegeveven als parameter of moest deze in session zitten
        //$gefilterdeLijst = array_filter($categorieLijst, function($categorie){return (($categorie->getHoofdcategorieId()) ===  $categorieId); });


        //lijst subcategorieën ophalen uit database
        $categorieDAO = new CategorieDAO();
        return $categorieDAO->getSubcategorieIds($categorieId);
    }


    //geeft lijst id's huidige categorie (=inputId) en alle categorieën die hieronder vallen (op alle niveaus)
    // om te gebruiken als filter in artikelcategorieën
    //geeft enkel de ids weer
    //recursieve functie, indien een categorie geen subcategorieën heeft bevat de lijst enkel de categorieId,
    //indien wel subcategorieën dan bevat de lijst ook de ids van de subcategorieën ( en hun subcategorieën )
    public function getAllCategorieIdsByCategorieID(int $categorieId)
    {
        $lijst = [$categorieId];
        $subcategorieIds = $this->getSubcategorieIdsById($categorieId);
        if ($subcategorieIds !== null) {
            foreach ($subcategorieIds as $subcategorieId) {
                array_push($lijst, ...$this->getAllCategorieIdsByCategorieID($subcategorieId));
            }
        }
        return $lijst;
    }
}
