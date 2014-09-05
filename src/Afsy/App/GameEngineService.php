<?php

namespace Afsy\App;

use Afsy\Blackjack\Domain\Model;
use Afsy\Blackjack\Domain\Repository\GameRepository;
use Afsy\Blackjack\Domain\Service\Dealer;
use Afsy\Blackjack\Domain\Service\Table;

class GameEngineService
{
    private $dealer;

    private $table;

    private $gameRepository;

    public function __construct(Dealer $dealer, Table $table, GameRepository $gameRepository)
    {
        $this->dealer = $dealer;
        $this->table = $table;
        $this->gameRepository = $gameRepository;
    }

    public function startGame(Command\StartGameCommand $command)
    {
        $discardPile = $this->dealer->deal(new Model\GameRules);
        $players = $this->table->hostPlayers($command->nbPlayers);

        $game = new Model\Game($command->gameId);
        $game->start($players, $discardPile);

        $this->gameRepository->save($game);
    }

    public function dealCard(Command\DealCardCommand $command)
    {
        $game = $this->gameRepository->find($command->gameId);
        $game->dealCard();

        $this->gameRepository->save($game);
    }

    public function stopDealCard(Command\StopDealCardCommand $command)
    {
        $game = $this->gameRepository->find($command->gameId);
        $game->stopDealCard();

        $this->gameRepository->save($game);
    }
}
