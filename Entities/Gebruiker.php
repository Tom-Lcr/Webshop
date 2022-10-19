<?php

declare(strict_types=1);

namespace Entities;

use Entities\Adres;

class Gebruiker
{
    private int $gebuikersAccountId;
    private string $emailAdres;
    private int $klantId;
    private persoon $persoon;
    private Adres $facturatieAdres;
    private Adres $leveringsAdres;


    public function __construct(int $gebruikersAccountId, string $emailAdres, int $klantId, Persoon $persoon, Adres $facturatieAdres, Adres $leveringsAdres)
    {
        $this->gebuikersAccountId = $gebruikersAccountId;
        $this->emailAdres = $emailAdres;
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
