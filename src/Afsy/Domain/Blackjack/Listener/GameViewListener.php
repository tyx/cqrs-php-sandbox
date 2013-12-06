<?php

namespace Afsy\Domain\Blackjack\Listener;

use Afsy\Domain\Blackjack\Event\CardDealt;
use Afsy\Domain\Blackjack\Event\GameCreated;
use Afsy\Domain\Blackjack\Event\GameOver;
use Afsy\Bundle\BlackjackBundle\Entity\Game;

class GameViewListener
{
    protected $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function onGameCreated(GameCreated $event)
    {
        $game = new Game();
        $game->setId($event->id);

        foreach ($event->players as $player) {
            if ($player->isHuman()) {
                $game->setPlayerCards($player->getCards());
            } else {
                $game->setBankCards($player->getCards());
            }
        }

        $this->doctrine->getManager()->persist($game);
        $this->doctrine->getManager()->flush();
    }

    public function onCardDealt(CardDealt $event)
    {
        $game = $this
            ->doctrine
            ->getManager()
            ->getRepository('Afsy\Bundle\BlackjackBundle\Entity\Game')
            ->find($event->id)
        ;

        if ($event->player->isHuman()) {
            $game->setPlayerCards($event->player->getCards());
        } else {
            $game->setBankCards($event->player->getCards());
        }

        $this->doctrine->getManager()->persist($game);
        $this->doctrine->getManager()->flush();
    }

    public function onGameOver(GameOver $event)
    {
        $game = $this
            ->doctrine
            ->getManager()
            ->getRepository('Afsy\Bundle\BlackjackBundle\Entity\Game')
            ->find($event->id)
        ;

        if ($event->player->isHuman()) {
            $game->setWinner('bank');
        } else {
            $game->setWinner('player');
        }

        $this->doctrine->getManager()->persist($game);
        $this->doctrine->getManager()->flush();
    }
}