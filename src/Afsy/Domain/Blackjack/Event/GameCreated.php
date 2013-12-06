<?php

namespace Afsy\Domain\Blackjack\Event;

use LiteCQRS\DefaultDomainEvent;
use Afsy\Domain\Blackjack\Model\DiscardPile;

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