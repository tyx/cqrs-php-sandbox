<?php

namespace Afsy\Blackjack\Domain\Specification;

use Afsy\Blackjack\Domain\Model\Player;

class GetVisibleCardSpec
{
    public function isSatisfiedBy(Player $player, $round)
    {
        return $player->isHuman() || $round != 1;
    }
}
