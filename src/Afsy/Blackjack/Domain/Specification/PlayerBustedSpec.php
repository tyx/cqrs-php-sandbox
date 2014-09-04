<?php

namespace Afsy\Blackjack\Domain\Specification;

use Afsy\Blackjack\Domain\Model\Player;

class PlayerBustedSpec
{
    const SCORE_LIMIT = 21;

    public function isSatisfiedBy(Player $player)
    {
        return $player->getPoints() > self::SCORE_LIMIT;
    }
}
