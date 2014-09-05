<?php

namespace Afsy\Blackjack\Domain\Model;

class DiscardPile
{
    protected $cards;

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public function deal($upturned = false)
    {
        $card = array_shift($this->cards);

        if (true === $upturned) {
            $card->upturn();
        }

        return $card;
    }
}
