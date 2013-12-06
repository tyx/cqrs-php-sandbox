<?php

namespace Afsy\Domain\Blackjack\Specification;

use Afsy\Domain\Blackjack\Model\Player;

class PlayerBustedSpec
{
    const SCORE_LIMIT = 21;

    public function isSatisfiedBy(Player $player)
    {
        return $player->getPoints() > self::SCORE_LIMIT;
    }
}
