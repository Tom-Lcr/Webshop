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

    public function getKlantenReviewId()
    {
        return $this->klantenReviewId;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getCommentaar()
    {
        return $this->commentaar;
    }

    public function getDatum()
    {
        return $this->datum;
    }

    public function getBestellijnId()
    {
        return $this->bestellijnId;
    }
}
