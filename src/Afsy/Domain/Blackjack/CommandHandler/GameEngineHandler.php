<?php

namespace Afsy\Domain\Blackjack\CommandHandler;

use Afsy\Domain\Blackjack\Command\StartGameCommand;
use Afsy\Domain\Blackjack\Command\DealCardCommand;
use Afsy\Domain\Blackjack\Command\StopDealCardCommand;
use Afsy\Domain\Blackjack\Model;

class GameEngineHandler
{
    protected $dealer;

    protected $repository;

    public function __construct($dealer, $repository)
    {
        $this->dealer = $dealer;
        $this->repository = $repository;
    }

    public function startGame(StartGameCommand $command)
    {
        $rules = new Model\GameRules();
        $discardPile = $rules->deal($this->dealer);

        $game = new Model\Game($command->gameId);
        $game->start($command->nbPlayers, $discardPile);

        $this->repository->save($game);
    }

    public function dealCard(DealCardCommand $command)
    {
        $game = $this->repository->find('Afsy\Domain\Blackjack\Model\Game', $command->gameId);
        $game->deal();

        $this->repository->save($game);
    }

    public function stopDealCard(StopDealCardCommand $command)
    {
        $game = $this->repository->find('Afsy\Domain\Blackjack\Model\Game', $command->gameId);
        $game->stop();

        $this->repository->save($game);
    }
}