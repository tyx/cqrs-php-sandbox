<?php

namespace Afsy\Domain\Blackjack\Service;

use Afsy\Domain\Blackjack\Model\Card;
use Afsy\Domain\Blackjack\Model\DiscardPile;

class Dealer
{
    public function createDiscardPile($colors, $value)
    {
        foreach ($colors as $color) {
            foreach ($value as $name => $points) {
                $cards[] = new Card($color, $name, $points);
            }
        }

        shuffle($cards);

        return new DiscardPile($cards);
    }
}