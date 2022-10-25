<?php

declare(strict_types=1);

namespace Entities;

class Opties
{

    //$statement = $dbh->prepare($this->metScores . "select * from artikelenMetScores ORDER BY $volgorde LIMIT ". ($pagina-1)*$aantalPerPagina . ", ". $aantalPerPagina);
    private string $volgorde = "rating desc, prijs desc";
    private ?int $categorie = null;
    private bool $enkelBeschikbaar;
    private bool $metRecentie;
    private ?string $zoekterm = null;

    public function __construct()
    {
        //$this->volgorde = $volgorde;
        //$this->categorie = null;
    }
    public function getVolgorde(): ?string
    {
        return $this->volgorde;
    }
    public function getCategorie(): ?int
    {
        return $this->categorie;
    }
    public function getZoekterm(): ?string
    {
        return $this->zoekterm;
    }

    public function getEnkelBeschikbaar(): bool
    {
        return $this->enkelBeschikbaar;
    }

    public function getMetRecentie(): bool
    {
        return $this->metRecentie;
    }

    public function getQuery(): string
    {
        $query = "";
        $alWhere = false;

        if($this->categorie) {
           $query = "WHERE categorieId in..." ;
           $alWhere = true; 
        }

        if($this->zoekterm){
            $query .= $alWhere ? "AND " : "WHERE";
            $query .= "naam is like '%$this->zoekterm%' ";
            $alWhere = true; 
        }

        if($this->enkelBeschikbaar){
            $query .= $alWhere ? "AND " : "WHERE";
            $query .= "voorraad>0";
            $alWhere = true; 
        }
        
        $query .= "ORDER BY $this->volgorde";
        return $query;
    }
}
