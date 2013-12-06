<?php

namespace Afsy\Domain\Blackjack\Command;

class DealCardCommand implements \LiteCQRS\Command
{
    public $gameId;

    public function __construct($gameId)
    {
        $this->gameId = $gameId;
    }
}