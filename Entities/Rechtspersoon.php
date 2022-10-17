<?php

declare(strict_types=1);

namespace Entities;

use Entities\Persoon;

class Rechtspersoon implements Persoon
{

    private string $naam;
    private string $btwNummer;
    private int $contactId;
    private string $contactVoornaam;
    private string $contactFamilienaam;
    private string $contactFunctie;

    public function __construct(string $naam, string $btwNummer, int $contactId, string $contactVoornaam, string $contactFamilienaam, string $contactFunctie)
    {
        $this->naam = $naam;
        $this->btwNummer = $btwNummer;
        $this->contactId = $contactId;
        $this->contactVoornaam = $contactVoornaam;
        $this->contactFamilienaam = $contactFamilienaam;
        $this->contactFamilienaam = $contactFunctie;
    }
    public function getNaam(): string
    {
        return $this->naam;
    }
    public function getBtwNummer(): string
    {
        return $this->btwNummer;
    }
    public function getContactId(): int
    {
        return $this->contactId;
    }
    public function getContactVoornaam(): string
    {
        return $this->contactVoornaam;
    }

    public function getContactFamilienaam(): string
    {
        return $this->contactFamilienaam;
    }

    public function getContactFunctie(): string
    {
        return $this->contactFunctie;
    }
}
