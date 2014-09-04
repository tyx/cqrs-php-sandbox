<?php

namespace Afsy\Blackjack\Domain\Repository;

use Afsy\Blackjack\Domain\Model\GameView;

interface GameViewRepository
{
    public function find($id);

    public function save(GameView $game);
}
