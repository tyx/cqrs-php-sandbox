<?php

namespace Afsy\Blackjack\Domain\Listener;

use Afsy\Blackjack\Domain\Event\CardDealt;
use Afsy\Blackjack\Domain\Event\GameCreated;
use Afsy\Blackjack\Domain\Event\GameOver;
use Afsy\Blackjack\Domain\Model\GameView;

use Afsy\Blackjack\Domain\Repository\GameViewRepository;

class GameViewListener
{
    protected $gameViewRepository;

    public function __construct(GameViewRepository $gameViewRepository)
    {
        $this->gameViewRepository = $gameViewRepository;
    }

    public function onGameCreated(GameCreated $event)
    {
        $this->gameViewRepository->save(
            new GameView($event->id, $event->players)
        );
    }

    public function onCardDealt(CardDealt $event)
    {
        $gameView = $this->gameViewRepository->find($event->id);
        $gameView->distributeCards($event->player);

        $this->gameViewRepository->save($gameView);
    }

    public function onGameOver(GameOver $event)
    {
        $game = $this->gameViewRepository->find($event->id);

        if ($event->player->isHuman()) {
            $game->award('bank');
        } else {
            $game->award('player');
        }

        $this->gameViewRepository->save($game);
    }
}
