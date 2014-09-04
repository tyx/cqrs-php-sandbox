<?php

namespace Afsy\Blackjack\Domain\Model;

class GameRules
{
    private $cardColors = ['diamond', 'heart', 'spade', 'club'];

    private $cardNames = [
        'A' => [11],
        '2' => [2],
        '3' => [3],
        '4' => [4],
        '5' => [5],
        '6' => [6],
        '7' => [7],
        '8' => [8],
        '9' => [9],
        '10' => [10],
        'J' => [10],
        'Q' => [10],
        'K' => [10]
    ];

    public function deal($dealer)
    {
        return $dealer->createDiscardPile($this->cardColors, $this->cardNames);
    }
}
