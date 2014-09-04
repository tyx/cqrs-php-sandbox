<?php

namespace Afsy\Blackjack\Domain\Event;

use LiteCQRS\DefaultDomainEvent;

use Afsy\Blackjack\Domain\Model\Player;

class GameOver extends DefaultDomainEvent
{
    public $id;

    public $player;

    public function __construct($id, Player $player)
    {
        $this->id = $id;
        $this->player = $player;
    }
}
