<?php

namespace Afsy\Blackjack\Domain\Event;

use LiteCQRS\DefaultDomainEvent;

use Afsy\Blackjack\Domain\Model\Player;

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
