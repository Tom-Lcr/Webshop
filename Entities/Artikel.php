<?php

declare(strict_types=1);

namespace Entities;


// Ik heb categorieen verwijderd uit de Entity Artikel die Jens had aangemaakt. Ik had dit besproken met Jens.
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

    private float $rating;


<<<<<<< HEAD
    public function __construct(int $artikelId, string $ean, string $naam, string $beschrijving, float $prijs, int $gewichtInGram, 
    int $voorraad, int $levertijd,  float $rating = null)
=======
    public function __construct(int $artikelId, string $ean, string $naam, string $beschrijving, float $prijs, int $gewichtInGram, int $voorraad, int $levertijd, float $rating = null)
>>>>>>> e95bd6f51fa3e8ede1524eba47572ef76501cc55
    {
        $this->artikelId = $artikelId;
        $this->ean = $ean;
        $this->naam = $naam;
        $this->beschrijving = $beschrijving;
        $this->prijs = $prijs;
        $this->gewichtInGram = $gewichtInGram;
        $this->voorraad = $voorraad;
        $this->levertijd = $levertijd;
        $this->rating = $rating;
    }
<<<<<<< HEAD
    
=======

>>>>>>> e95bd6f51fa3e8ede1524eba47572ef76501cc55
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

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating($rating): float
    {
        return $this->rating = $rating;
    }

<<<<<<< HEAD
    
=======

>>>>>>> e95bd6f51fa3e8ede1524eba47572ef76501cc55
    public function isInVoorraad(): bool
    {
        if ($this->voorraad > 0) {
            return true;
<<<<<<< HEAD
        }else{
            return false;
        }
        
    }  
}
=======
        } else {
            return false;
        }
    }
}
>>>>>>> e95bd6f51fa3e8ede1524eba47572ef76501cc55
