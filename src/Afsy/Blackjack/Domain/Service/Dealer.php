<?php

namespace Afsy\Blackjack\Domain\Service;

use Afsy\Blackjack\Domain\Model\Card;
use Afsy\Blackjack\Domain\Model\DiscardPile;

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
