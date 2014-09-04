<?php

namespace Afsy\Blackjack\Domain\Specification;

use Afsy\Blackjack\Domain\Model\Player;

class DealerLimitSpec
{
    const SCORE_LIMIT = 17;

    public function isSatisfiedBy(Player $player)
    {
        return $player->getPoints() >= self::SCORE_LIMIT;
    }
}
