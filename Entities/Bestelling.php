<?php

declare(strict_types=1);

namespace Entities;

use DateTime;

class Bestelling
{
    private ?int $bestelId;
    private ?string $besteldatum;
    private ?int $klantId;
    private ?bool $betaald;
    private ?string $betalingscode;
    private ?string $betaalwijze;
    private ?bool $annulatie;

    private ?string $terugbetalingscode;
    private ?string $bestellingsstatus;
    private ?bool $actiecodeGebruikt;
    private ?string $bedrijfsnaam;
    private ?string $btwNummer;
    private ?string $voornaam;
    private ?string $familienaam;
    private ?Adres $facturatieAdres;
    private ?Adres $leveringsAdres;

    private ?array $bestellijnen;

    public function __construct(
        ?int $bestelId = null,
        ?string $besteldatum = null,
        ?int $klantId = null,
        ?bool $betaald = null,
        ?string $betalingscode = null,
        ?string $betaalwijze = null,
        ?bool $annulatie = null,
        ?string $terugbetalingsCode = null,
        ?string $bestellingstatus = null,
        ?bool $actiecodeGebruikt = null,
        ?string $bedrijfsnaam = null,
        ?string $btwNummer = null,
        ?string $voornaam = null,
        ?string $familienaam = null,
        ?Adres $facturatieAdres = null,
        ?Adres $leveringsAdres = null,
        ?array $bestellijnen = []
    ) {
        $this->bestelId = $bestelId;
        $this->besteldatum = $besteldatum;
        $this->klantId = $klantId;
        $this->betaald = $betaald;
        $this->betalingscode = $betalingscode;
        $this->betaalwijze = $betaalwijze;
        $this->annulatie = $annulatie;
        $this->terugbetalingscode = $terugbetalingsCode;
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
        return $this->terugbetalingscode;
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


    //SETTERS

    public function setBestelId($bestelId)
    {
        $this->bestelId = $bestelId;
    }

    public function setKlantId($klantId)
    {
        $this->klantId = $klantId;
    }
    public function setBetaald($betaald)
    {
        $this->betaald = $betaald;
    }
    public function setBetalingscode($code)
    {
        $this->betalingscode = $code;
    }
    public function setBetaalwijze($betaalwijze)
    {
        $this->betaalwijze = $betaalwijze;
    }
    public function setAnnulatie($annulatie)
    {
        $this->annulatie = $annulatie;
    }
    public function setTerugbetalingscode($terugbetalingsCode)
    {
        $this->terugbetalingscode = $terugbetalingsCode;
    }
    public function setBestellingsstatus($bestellingsstatus)
    {
        $this->bestellingsstatus = $bestellingsstatus;
    }
    public function setActiecodeGebruikt($actiecodeGebruikt)
    {
        $this->actiecodeGebruikt = $actiecodeGebruikt;
    }
    public function setBedrijfsnaam($bedrijfsnaam)
    {
        $this->bedrijfsnaam = $bedrijfsnaam;
    }
    public function setBtwNummer($btwNummer)
    {
        $this->btwNummer = $btwNummer;
    }
    public function setVoornaam($voornaam)
    {
        $this->voornaam = $voornaam;
    }
    public function setFamilienaam($familienaam)
    {
        $this->familienaam = $familienaam;
    }
    public function setFacturatieAdres($facturatieAdres)
    {
        $this->facturatieAdres = $facturatieAdres;
    }
    public function setLeveringsAdres($leveringsAdres)
    {
        $this->leveringsAdres = $leveringsAdres;
    }

    public function setBestellijnen($bestellijnen)
    {
        $this->bestellijnen = $bestellijnen;
    }

    public function voegBestellijnToe(Bestellijn $bestellijn)
    {
        array_push($this->bestellijnen, $bestellijn);
    }
}
