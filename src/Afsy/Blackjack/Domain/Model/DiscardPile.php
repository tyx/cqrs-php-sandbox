<?php

namespace Afsy\Blackjack\Domain\Model;

use Afsy\Blackjack\Domain\Specification\GetVisibleCardSpec;

class DiscardPile
{
    protected $cards;

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public function dealToPlayer(Player $player, $round)
    {
        $visibleCard = new GetVisibleCardSpec;

        if ($visibleCard->isSatisfiedBy($player, $round)) {
            $player->receiveCard($this->dealUpturned());
        } else {
            $player->receiveCard($this->dealDownturned());
        }
    }

    private function dealUpturned()
    {
        return $this->deal(true);
    }

    private function dealDownturned()
    {
        return $this->deal(false);
    }

    private function deal($upturned = false)
    {
        $card = array_shift($this->cards);

        if (true === $upturned) {
            $card->upturn();
        }

        return $card;
    }
}
