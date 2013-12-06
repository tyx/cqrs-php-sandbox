<?php

namespace Afsy\Domain\Blackjack\Event;

use LiteCQRS\DefaultDomainEvent;

use Afsy\Domain\Blackjack\Model\Player;

class DealerStopped extends DefaultDomainEvent
{
    public $gameId;

    public $player;

    public function __construct($gameId, Player $player)
    {
        $this->gameId = $gameId;
        $this->player = $player;
    }
}
