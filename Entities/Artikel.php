<?php

declare(strict_types=1);

namespace Entities;


//artikel heeft een array van categorieIds
class Artikel
{
    private int $artikelId;
    private string $ean;
    private string $naam;
    private string $beschrijving;
    private float $prijs;
    private int $gewichtInGram;
    private int $voorraad;
    private int $levertijd;
    private array $categorieen;
    private float $rating;


    public function __construct(int $artikelId, string $ean, string $naam, string $beschrijving, float $prijs, int $gewichtInGram, 
    int $voorraad, int $levertijd,  float $rating = null)
    {
        $this->artikelId = $artikelId;
        $this->ean = $ean;
        $this->naam = $naam;
        $this->beschrijving = $beschrijving;
        $this->prijs = $prijs;
        $this->gewichtInGram = $gewichtInGram;
        $this->voorraad = $voorraad;
        $this->levertijd = $levertijd;
        $this->$categorieen = $categorieen;
        $this->rating = $rating;
    }
    
    public function getArtikelId(): int
    {
        return $this->artikelId;
    }
    public function getEan(): string
    {
        return $this->ean;
    }
    public function getNaam(): string
    {
        return $this->naam;
    }
    public function getBeschrijving(): string
    {
        return $this->beschrijving;
    }
    public function getPrijs(): float
    {
        return $this->prijs;
    }
    public function getGewichtInGram(): int
    {
        return $this->gewichtInGram;
    }
    public function getVoorraad(): int
    {
        return $this->voorraad;
    }
    public function getLevertijd(): int
    {
        return $this->levertijd;
    }
    public function getCategorieen(): array
    {
        return $this->categorieen;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating($rating): float
    {
        return $this->rating = $rating;
    }
}
