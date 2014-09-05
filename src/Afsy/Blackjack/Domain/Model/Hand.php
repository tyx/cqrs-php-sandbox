<?php

namespace Afsy\Blackjack\Domain\Model;

class Hand
{
    private $cards;

    private $score;

    public function __construct()
    {
        $this->cards = array();
        $this->score = 0;
    }

    public function receiveCard(Card $card)
    {
        $this->cards[] = $card;
        $this->score += $card->getPoints();
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function getScore()
    {
        return $this->score;
    }
}
