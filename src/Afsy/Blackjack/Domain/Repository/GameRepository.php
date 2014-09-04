<?php

namespace Afsy\Blackjack\Domain\Repository;

use Afsy\Blackjack\Domain\Model\Game;

interface GameRepository
{
    public function find($id);

    public function save(Game $game);
}
