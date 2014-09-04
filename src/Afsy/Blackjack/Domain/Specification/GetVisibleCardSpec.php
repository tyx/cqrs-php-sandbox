<?php

namespace Afsy\Blackjack\Domain\Specification;

use Afsy\Blackjack\Domain\Model\Player;

class GetVisibleCardSpec
{
    public function isSatisfiedBy(Player $player, $index)
    {
        return $player->isHuman() || $index != 1;
    }
}
