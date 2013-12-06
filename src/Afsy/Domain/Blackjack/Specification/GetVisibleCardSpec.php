<?php

namespace Afsy\Domain\Blackjack\Specification;

use Afsy\Domain\Blackjack\Model\Player;

class GetVisibleCardSpec
{
    public function isSatisfiedBy(Player $player, $index)
    {
        return $player->isHuman() || $index != 1;
    }
}