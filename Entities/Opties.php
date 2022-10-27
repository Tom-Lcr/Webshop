<?php

declare(strict_types=1);

namespace Entities;

use Business\CategorieService;

class Opties
{

    //todo eerst sorteren op kolom heeftRating desc (nog toe te voegen) en dan op rating, zodat artikelen met rating steeds bovenaan staan

    private int $volgorde = 1;
    private ?int $categorie = null;
    private bool $enkelBeschikbaar = false;
    private bool $metRecentie = true;
    private bool $zonderRecentie = true;
    private ?string $zoekterm = null;


    public function getVolgorde(): ?int
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


    public function getZonderRecentie(): bool
    {
        return $this->zonderRecentie;
    }

    //<option value="1">Waardering - hoog</option>
    //                      <option value="2">Waardering - laag</option>
    //                     <option value="3">Prijs - hoog</option>
    //                    <option value="4">Prijs - laag</option>
    public function setVolgorde(int $volgordeNummer)
    {
        $this->volgorde = $volgordeNummer;
    }
    public function setCategorie(int $hoofdcategorie)
    {
        return $this->categorie = $hoofdcategorie;
    }


    public function setZoekterm(string $zoekterm)
    {
        $this->zoekterm = $zoekterm;
    }

    public function setEnkelBeschikbaar(bool $enkelBeschikbaar)
    {
        $this->enkelBeschikbaar = $enkelBeschikbaar;
    }

    public function setMetRecentie(bool $metRecentie)
    {
        $this->metRecentie = $metRecentie;
    }


    public function setZonderRecentie(bool $zonderRecentie)
    {
        $this->zonderRecentie = $zonderRecentie;
    }

    //als zowel met recentie als zonder recentie afgevinkt zijn, beide aanvinken
    public function controleerRecenties()
    {
        if (!$this->metRecentie && !$this->zonderRecentie) {
            $this->metRecentie = true;
            $this->zonderRecentie = true;
        }
    }

    public function getQuery(): string
    {
        $query = "";
        $alWhere = false;

        if ($this->categorie) {
            $categorieIds = (new CategorieService())->getAllCategorieIdsByCategorieID($this->categorie);
            $query = " WHERE artikelId IN ( SELECT DISTINCT artikelId FROM artikelcategorieen WHERE categorieId IN (" . implode(',', $categorieIds) . "))";
            $alWhere = true;
        }

        if ($this->zoekterm) {
            $query .= $alWhere ? " AND " : "WHERE ";
            $query .= "naam like '%$this->zoekterm%' ";
            $alWhere = true;
        }

        if ($this->enkelBeschikbaar) {
            $query .= $alWhere ? " AND " : "WHERE ";
            $query .= "voorraad>0";
            $alWhere = true;
        }

        if (!$this->metRecentie) {
            $query .= $alWhere ? " AND " : "WHERE ";
            $query .= "rating IS NULL";
            $alWhere = true;
        }

        if (!$this->zonderRecentie) {
            $query .= $alWhere ? " AND " : "WHERE ";
            $query .= "rating IS NOT NULL";
            $alWhere = true;
        }

        $query .= " ORDER BY "; 

        switch ($this->volgorde) {
            case 2:
                $query .= "rating asc, prijs asc";
                break;

            case 3:
                $query .= "prijs desc, rating desc";
                break;

            case 4:
                $query .= "prijs asc, rating desc";
                break;

            default:
            $query .= "rating desc, prijs desc";
                break;
        };        
        return $query;
    }
}
