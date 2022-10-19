<?php

declare(strict_types=1);

namespace Entities;

class Plaats
{
    private $plaatsId;
    private string $plaatsNaam;
    private string $postcode;

    public function __construct($plaatsId, $plaatsNaam, $postcode)
    {
        $this->plaatsId = $plaatsId;
        $this->plaatsNaam = $plaatsNaam;
        $this->postcode = $postcode;
    }
    public function getPLaatsId(): int
    {
        return $this->plaatsId;
    }
    public function getplaatsNaam(): string
    {
        return $this->plaatsNaam;
    }
    public function getPostcode(): string
    {
        return $this->postcode;
    }
}
