<?php

namespace Afsy\Blackjack\Domain\Event;

use LiteCQRS\DefaultDomainEvent;
use Afsy\Blackjack\Domain\Model\DiscardPile;

class GameCreated extends DefaultDomainEvent
{
    public $players;

    public $discardPile;

    public $round;

    public function __construct(array $players, DiscardPile $discardPile, $round)
    {
        $this->players = $players;
        $this->discardPile = $discardPile;
        $this->round = $round;
    }
}
