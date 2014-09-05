<?php

namespace Afsy\Blackjack\Domain\Service;

use Afsy\Blackjack\Domain\Model\Player;
use Afsy\Blackjack\Domain\Model\PlayerIdentity;

class Table
{
    public function hostPlayers($nbPlayers)
    {
        $players = [];

        for ($i = 0; $i < $nbPlayers; $i++) {
            if (0 == $i) {
                $players[] = $this->createPlayer('Joueur 1', true, false);
            } else {
                $players[] = $this->createPlayer('Computer '.$i, false, true);
            }
        }

        return $players;
    }

    private function createPlayer($name, $human, $bank)
    {
        return new Player(
            new PlayerIdentity($name, $human),
            $bank
        );
    }
}
