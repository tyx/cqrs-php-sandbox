<?php

namespace Afsy\App;

use Rhumsaa\Uuid\Uuid;

use Afsy\Blackjack\Domain\Repository\GameViewRepository;

class GameViewQuery
{
    private $gameViewRepository;

    public function __construct(GameViewRepository $gameViewRepository)
    {
        $this->gameViewRepository = $gameViewRepository;
    }

    public function requestGameView(Uuid $uuid)
    {
        $gameView = $this
            ->gameViewRepository
            ->find($uuid)
        ;

        if (null === $gameView) {
            throw new Exception\NotFoundGameViewException;
        }

        return $gameView;
    }
}
