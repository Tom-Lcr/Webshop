<?php

declare(strict_types=1);

namespace Entities;

use Entities\Adres;

class Gebruiker
{
    private int $gebuikersAccountId;
    private string $emailAdres;
    private ?int $klantId;
    private ?persoon $persoon;
    private ?Adres $facturatieAdres;
    private ?Adres $leveringsAdres;


    public function __construct(int $gebruikersAccountId, string $emailAdres, ?int $klantId = null, ?Persoon $persoon = null, ?Adres $facturatieAdres = null, ?Adres $leveringsAdres = null)
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

    public function setKlantId(int $id)
    {
        $this->klantId = $id;
    }

    public function setPersoon(Persoon $persoon)
    {
        $this->persoon = $persoon;
    }

    public function setFacturatieAdres(Adres $adres)
    {
        $this->facturatieAdres = $adres;
    }

    public function setLeveringsAdres(Adres $adres)
    {
        $this->leveringsAdres = $adres;
    }
}
