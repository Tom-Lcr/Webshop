<?php

declare(strict_types=1);

namespace Entities;

class Categorie
{
    private $categorieId;
    private string $naam;
    private int $hoofdcategorieId;

    public function __construct(int $categorieId, string $naam, int $hoofdcategorieId)
    {
        $this->categorieId = $categorieId;
        $this->naam = $naam;
        $this->hoofdcategorieId = $hoofdcategorieId;
    }
    public function getCategorieId(): int
    {
        return $this->categorieId;
    }
    public function getNaam(): string
    {
        return $this->naam;
    }
    public function getHoofdcategorieId(): int
    {
        return $this->hoofdcategorieId;
    }
}
