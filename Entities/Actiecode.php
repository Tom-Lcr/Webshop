<?php

declare(strict_types=1);

namespace Entities;

use Business\ActiecodeService;
use DateTime;
use Exceptions\ActieCodeBestaatNietException;
use Exceptions\ActieCodeNietMeerGeldigException;

class Actiecode
{
    private int $actiecodeId;
    private string $naam;
    private DateTime $geldigVanDatum;
    private DateTime $geldigTotDatum;
    private bool $isEenmalig;


    public function __construct(int $actiecodeId, string $naam, DateTime $geldigVanDatum, DateTime $geldigTotDatum, bool $isEenmalig)
    {
        $this->actiecodeId = $actiecodeId;
        $this->naam = $naam;
        $this->geldigVanDatum = $geldigVanDatum;
        $this->geldigTotDatum = $geldigTotDatum;
        $this->isEenmalig = $isEenmalig;
    }

    public function getActiecodeId(): int
    {
        return $this->actiecodeId;
    }

    public function getNaam(): string
    {
        return $this->naam;
    }

    public function getGeldigVanDatum(): DateTime
    {
        return $this->geldigVanDatum;
    }

    public function getGeldigTotDatum(): DateTime
    {
        return $this->geldigTotDatum;
    }

    public function getIsEenmalig(): bool
    {
        return $this->isEenmalig;
    }    
}
