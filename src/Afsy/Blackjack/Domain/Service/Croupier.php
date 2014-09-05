<?php

namespace Afsy\Blackjack\Domain\Service;

use Afsy\Blackjack\Domain\Model\Hand;

class Croupier
{
    public function findWinner(array $players)
    {
        $max = 0;
        $winner = null;

        foreach ($players as $player) {
            $this->upturnHand($player->getHand());

            if ($player->getScore() > $max) {
                $max = $player->getScore();
                $winner = $player;
            }
        }

        return $winner;
    }

    public function upturnHand(Hand $hand)
    {
        foreach ($hand->getCards() as $card) {
            $card->upturn();
        }
    }
}
