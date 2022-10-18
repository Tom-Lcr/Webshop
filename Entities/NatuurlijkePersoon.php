<?php

declare(strict_types=1);

namespace Entities;

use Entities\Persoon;

class NatuurlijkePersoon implements Persoon
{

    private string $voornaam;
    private string $familienaam;

    public function __construct(string $voornaam, string $familienaam)
    {
        $this->voornaam = $voornaam;
        $this->familienaam = $familienaam;
    }
    public function getVoornaam(): string
    {
        return $this->voornaam;
    }
    public function getFamilienaam(): string
    {
        return $this->familienaam;
    }

    public function getNaam(): string
    {
        return $this->getVoornaam() . " " . $this->getFamilienaam();
    }
}
