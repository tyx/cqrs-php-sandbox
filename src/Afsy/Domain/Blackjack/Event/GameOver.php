<?php

namespace Afsy\Domain\Blackjack\Event;

use LiteCQRS\DefaultDomainEvent;

use Afsy\Domain\Blackjack\Model\Player;

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