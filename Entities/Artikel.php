<?php
declare(strict_types = 1);

namespace Entities;



class Artikel {
    
    private int $artikelId;
    private string $naam;
    private float $prijs;
    private int $voorraad;
    
    public function __construct(int $artikelId, string $naam, float $prijs, int $voorraad){
        $this->artikelId = $artikelId;
        $this->naam = $naam;
        $this->prijs = $prijs;
        $this->voorraad = $voorraad;
    }
    
    
      
    public function getArtikelId(): int
    {
        return $this->artikelId;
    }
    
    public function getNaam() : string{
        return $this->naam;
    }
    
    public function getPrijs(): float
    {
        return $this->prijs;
    }
    
    public function isInVoorraad(): bool
    {
        if ($this->voorraad > 0) {
            return true;
        }else{
            return false;
        }
        
    }  
}