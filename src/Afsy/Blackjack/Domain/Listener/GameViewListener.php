<?php

namespace Afsy\Blackjack\Domain\Listener;

use Afsy\Blackjack\Domain\Event\CardDealt;
use Afsy\Blackjack\Domain\Event\GameCreated;
use Afsy\Blackjack\Domain\Event\GameOver;
use Afsy\Blackjack\Domain\Model\GameView;

class GameViewListener
{
    protected $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function onGameCreated(GameCreated $event)
    {
        $game = new GameView();
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
            ->getRepository('Afsy\Blackjack\Domain\Model\GameView')
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
            ->getRepository('Afsy\Blackjack\Domain\Model\GameView')
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
