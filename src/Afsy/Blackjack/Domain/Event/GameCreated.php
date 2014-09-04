<?php

namespace Afsy\Blackjack\Domain\Event;

use LiteCQRS\DefaultDomainEvent;
use Afsy\Blackjack\Domain\Model\DiscardPile;

class GameCreated extends DefaultDomainEvent
{
    public $id;

    public $players;

    public $discardPile;

    public function __construct($id, $players, DiscardPile $discardPile)
    {
        $this->id = $id;
        $this->players = $players;
        $this->discardPile = $discardPile;
    }
}
