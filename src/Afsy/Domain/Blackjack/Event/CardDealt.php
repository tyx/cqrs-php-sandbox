<?php

namespace Afsy\Domain\Blackjack\Event;

use LiteCQRS\DefaultDomainEvent;
use Afsy\Domain\Blackjack\Model\Player;
use Afsy\Domain\Blackjack\Model\DiscardPile;

class CardDealt extends DefaultDomainEvent
{
    public $id;

    public $player;

    public $discardPile;

    public function __construct($id, Player $player, DiscardPile $discardPile)
    {
        $this->id = $id;
        $this->player = $player;
        $this->discardPile = $discardPile;
    }
}