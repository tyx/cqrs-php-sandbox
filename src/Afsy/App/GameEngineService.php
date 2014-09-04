<?php

namespace Afsy\App;

use Afsy\Blackjack\Domain\Model;
use Afsy\Blackjack\Domain\Repository\GameRepository;
use Afsy\Blackjack\Domain\Service\Dealer;

class GameEngineService
{
    protected $dealer;

    protected $repository;

    public function __construct(Dealer $dealer, GameRepository $repository)
    {
        $this->dealer = $dealer;
        $this->repository = $repository;
    }

    public function startGame(Command\StartGameCommand $command)
    {
        $rules = new Model\GameRules;
        $discardPile = $rules->deal($this->dealer);

        $game = new Model\Game($command->gameId);
        $game->start($command->nbPlayers, $discardPile);

        $this->repository->save($game);
    }

    public function dealCard(Command\DealCardCommand $command)
    {
        $game = $this->repository->find($command->gameId);
        $game->deal();

        $this->repository->save($game);
    }

    public function stopDealCard(Command\StopDealCardCommand $command)
    {
        $game = $this->repository->find($command->gameId);
        $game->stop();

        $this->repository->save($game);
    }
}
