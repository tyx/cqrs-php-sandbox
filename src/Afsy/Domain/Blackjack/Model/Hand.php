<?php

namespace Afsy\Domain\Blackjack\Model;

class Hand
{
    protected $cards;

    public function __construct($cards = array())
    {
        $this->cards = $cards;
    }

    public function receiveCards($cards)
    {
        $this->cards = array_merge($this->cards, $cards);
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function getPoints()
    {
        $score = 0;

        foreach ($this->cards as $card) {
            $card->upturn();

            foreach ($card->getPoints() as $v) {
                $score += $v;
            }
        }

        return $score;
    }
}