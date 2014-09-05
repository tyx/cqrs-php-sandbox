<?php

namespace Afsy\Blackjack\Domain\Event;

use LiteCQRS\DefaultDomainEvent;
use Afsy\Blackjack\Domain\Model\Player;
use Afsy\Blackjack\Domain\Model\DiscardPile;

class CardDealt extends DefaultDomainEvent
{
    public $id;

    public $player;

    public $discardPile;

    public $round;

    public function __construct($id, Player $player, DiscardPile $discardPile, $round)
    {
        $this->id = $id;
        $this->player = $player;
        $this->discardPile = $discardPile;
        $this->round = $round;
    }
}
