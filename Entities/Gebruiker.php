<?php

declare(strict_types=1);

namespace Entities;

use Entities\Adres;

class Gebruiker
{
    private int $gebuikersAccountId;
    private string $emailAdres;
    private string $paswoord;
    private bool $disabled;
    private int $klantId;
    private persoon $persoon;
    private Adres $facturatieAdres;
    private Adres $leveringsAdres;


    public function __construct(int $gebruikersAccountId, string $emailAdres, string $paswoord, bool $disabled, int $klantId, Persoon $persoon, Adres $facturatieAdres, Adres $leveringsAdres)
    {
        $this->gebuikersAccountId = $gebruikersAccountId;
        $this->emailAdres = $emailAdres;
        $this->paswoord = $paswoord;
        $this->disabled = $disabled;
        $this->klantId = $klantId;
        $this->persoon = $persoon;
        $this->facturatieAdres = $facturatieAdres;
        $this->leveringsAdres = $leveringsAdres;
    }

    public function getGebruikersAccountId(): int
    {
        return $this->gebuikersAccountId;
    }

    public function getEmailAdres(): string
    {
        return $this->emailAdres;
    }

    public function getPaswoord(): string
    {
        return $this->paswoord;
    }

    public function getDisabled(): bool
    {
        return $this->disabled;
    }

    public function getKlantId(): int
    {
        return $this->klantId;
    }

    public function getPersoon(): Persoon
    {
        return $this->persoon;
    }

    public function getFacturatieAdres(): Adres
    {
        return $this->facturatieAdres;
    }

    public function getLeveringsAdres(): Adres
    {
        return $this->leveringsAdres;
    }

    public function getNaam(): string
    {
        return $this->getPersoon()->getNaam();
    }
}
