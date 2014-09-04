<?php

namespace Afsy\App;

use Rhumsaa\Uuid\Uuid;

class GameViewQuery
{
    private $gameViewRepository;

    public function __construct($gameViewRepository)
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
