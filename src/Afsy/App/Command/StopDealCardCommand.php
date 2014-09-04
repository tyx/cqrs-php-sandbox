<?php

namespace Afsy\App\Command;

class StopDealCardCommand implements \LiteCQRS\Command
{
    public $gameId;

    public function __construct($gameId)
    {
        $this->gameId = $gameId;
    }
}
