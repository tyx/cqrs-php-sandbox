<?php

namespace Afsy\Blackjack\Domain\Model;

use LiteCQRS\AggregateRoot;
use Rhumsaa\Uuid\Uuid;

use Afsy\Blackjack\Domain\Event\PlayerIdentityCreated;

class PlayerIdentity
{
    protected $name;

    protected $human;

    public function __construct($name, $human)
    {
        $this->name = $name;
        $this->human = $human;
    }

    public function isHuman()
    {
        return true === $this->human;
    }
}
