<?php

declare(strict_types=1);

namespace Entities;

class Adres
{
    private int $adresId;
    private string $straat;
    private string $huisNummer;
    private string $bus;
    private Plaats $plaats;
    private bool $actief;


    public function __construct(int $adresId, string $straat, string $huisNummer, string $bus, Plaats $plaats, bool $actief)
    {
        $this->adresId = $adresId;
        $this->straat = $straat;
        $this->huisNummer = $huisNummer;
        $this->bus = $bus;
        $this->plaats = $plaats;
        $this->actief = $actief;
    }
    public function getAdresId(): int
    {
        return $this->adresId;
    }

    public function getStraat(): string
    {
        return $this->straat;
    }

    public function getHuisNummer(): string
    {
        return $this->huisNummer;
    }

    public function getBus(): string
    {
        return $this->bus;
    }

    public function getPlaats(): Plaats
    {
        return $this->plaats;
    }

    public function getActief(): bool
    {
        return $this->actief;
    }
}
