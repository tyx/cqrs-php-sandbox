<?php

namespace Afsy\App\Command;

class DealCardCommand implements \LiteCQRS\Command
{
    public $gameId;

    public function __construct($gameId)
    {
        $this->gameId = $gameId;
    }
}
