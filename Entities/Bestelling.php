<?php

declare(strict_types=1);

namespace Entities;

use DateTime;

class Bestelling
{
    private ?int $bestelId;
    private ?string $besteldatum;
    private int $klantId;
    private bool $betaald;
    private ?string $betalingscode;
    private string $betaalwijze;
    private ?bool $annulatie;

    private ?string $terugetalingscode;
    private ?string $bestellingsstatus;
    private ?bool $actiecodeGebruikt;
    private ?string $bedrijfsnaam;
    private ?string $btwNummer;
    private string $voornaam;
    private string $familienaam;
    private Adres $facturatieAdres;
    private Adres $leveringsAdres;

    private array $bestellijnen;

    public function __construct(
        ?int $bestelId,
        ?string $besteldatum,
        int $klantId,
        ?bool $betaald,
        ?string $betalingscode,
        string $betaalwijze,
        ?bool $annulatie,
        ?string $terubetalingsCode,
        ?string $bestellingstatus,
        ?bool $actiecodeGebruikt,
        ?string $bedrijfsnaam,
        ?string $btwNummer,
        string $voornaam,
        string $familienaam,
        Adres $facturatieAdres,
        Adres $leveringsAdres,
        ?array $bestellijnen = []
    ) {
        $this->bestelId = $bestelId;
        $this->besteldatum = $besteldatum;
        $this->klantId = $klantId;
        $this->betaald = $betaald;
        $this->betalingscode = $betalingscode;
        $this->betaalwijze = $betaalwijze;
        $this->annulatie = $annulatie;
        $this->terugetalingscode = $terubetalingsCode;
        $this->bestellingsstatus = $bestellingstatus;
        $this->actiecodeGebruikt = $actiecodeGebruikt;
        $this->bedrijfsnaam = $bedrijfsnaam;
        $this->btwNummer = $btwNummer;
        $this->voornaam = $voornaam;
        $this->familienaam = $familienaam;
        $this->facturatieAdres = $facturatieAdres;
        $this->leveringsAdres = $leveringsAdres;
        $this->bestellijnen = $bestellijnen;
    }
    public function getBestelId(): ?int
    {
        return $this->bestelId;
    }
    public function getBesteldatum(): ?string
    {
        return $this->besteldatum;
    }
    public function getKlantId(): int
    {
        return $this->klantId;
    }
    public function getBetaald(): ?bool
    {
        return $this->betaald;
    }
    public function getBetalingscode(): ?string
    {
        return $this->betalingscode;
    }
    public function getBetaalwijze(): ?string
    {
        return $this->betaalwijze;
    }
    public function getAnnulatie(): ?bool
    {
        return $this->annulatie;
    }
    public function getTerugbetalingscode(): ?string
    {
        return $this->terugetalingscode;
    }
    public function getBestellingsstatus(): ?string
    {
        return $this->bestellingsstatus;
    }
    public function getActiecodeGebruikt(): ?bool
    {
        return $this->actiecodeGebruikt;
    }
    public function getBedrijfsnaam(): ?string
    {
        return $this->bedrijfsnaam;
    }
    public function getBtwNummer(): ?string
    {
        return $this->btwNummer;
    }
    public function getVoornaam(): string
    {
        return $this->voornaam;
    }
    public function getFamilienaam(): string
    {
        return $this->familienaam;
    }
    public function getFacturatieAdres(): Adres
    {
        return $this->facturatieAdres;
    }
    public function getLeveringsAdres(): Adres
    {
        return $this->leveringsAdres;
    }

    public function getBestellijnen(): ?array
    {
        return $this->bestellijnen;
    }

    public function voegBestellijnToe(Bestellijn $bestellijn)
    {
        array_push($bestellijnen, $bestellijn);
    }
}
