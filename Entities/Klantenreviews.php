<?php

declare(strict_types=1);

namespace Entities;

use DateTime;

//artikel heeft een array van categorieIds
class Klantenreviews
{
    private int $klantenReviewId;
    private string $nickname;
    private int $score;
    private string $commentaar;
    private DateTime $datum;
    private int $bestellijnId;

    public function __construct(int $klantenReviewId, string $nickname, int $score, string $commentaar, DateTime $datum, int $bestellijnId)
    {
        $this->klantenReviewId = $klantenReviewId;
        $this->nickname = $nickname;
        $this->score = $score;
        $this->commentaar = $commentaar;
        $this->datum = $datum;
        $this->bestellijnId = $bestellijnId;
    }

    public function getKlantenReviewId() :int
    {
        return $this->klantenReviewId;
    }

    public function getNickname() :string
    {
        return $this->nickname;
    }

    public function getScore() :int
    {
        return $this->score;
    }

    public function getCommentaar() :string
    {
        return $this->commentaar;
    }

    public function getDatum() :DateTime
    {
        return $this->datum;
    }

    public function getBestellijnId() :int
    {
        return $this->bestellijnId;
    }
}
