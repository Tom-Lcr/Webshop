<?php

declare(strict_types=1);

namespace Entities;

class Plaats
{
    private $plaatsId;
    private string $postcode;
    private string $plaatsNaam;

    public function __construct($plaatsId, $postcode, $plaatsNaam)
    {
        $this->plaatsId = $plaatsId;
        $this->postcode = $postcode;
        $this->plaatsNaam = $plaatsNaam;  
    }
    public function getPLaatsId(): int
    {
        return $this->plaatsId;
    }
    public function getPostcode(): string
    {
        return $this->postcode;
    }
    public function getplaatsNaam(): string
    {
        return $this->plaatsNaam;
    }
    
}
