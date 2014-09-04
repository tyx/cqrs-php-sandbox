<?php

namespace Afsy\Blackjack\Domain\Event;

use LiteCQRS\DefaultDomainEvent;

class PlayerIdentityCreated extends DefaultDomainEvent
{
    public $id;

    public $name;

    public $human;

    public function __construct($id, $name, $human)
    {
        $this->id = $id;
        $this->name = $name;
        $this->human = $human;
    }
}
