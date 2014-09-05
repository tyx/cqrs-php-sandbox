<?php

namespace Afsy\Blackjack\Domain\Service;

use Afsy\Blackjack\Domain\Model\Card;
use Afsy\Blackjack\Domain\Model\DiscardPile;
use Afsy\Blackjack\Domain\Model\GameRules;

class Dealer
{
    public function deal(GameRules $gameRules)
    {
        $colors = $gameRules->getCardColors();
        $values = $gameRules->getCardValues();

        foreach ($colors as $color) {
            foreach ($values as $name => $points) {
                $cards[] = new Card($color, $name, $points);
            }
        }

        shuffle($cards);

        return new DiscardPile($cards);
    }
}
