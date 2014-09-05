<?php

namespace Afsy\Blackjack\Domain\Model;

use LiteCQRS\AggregateRoot;

use Afsy\Blackjack\Domain\Event\CardDealt;
use Afsy\Blackjack\Domain\Event\GameCreated;
use Afsy\Blackjack\Domain\Event\GameOver;
use Afsy\Blackjack\Domain\Event\DealerStopped;
use Afsy\Blackjack\Domain\Specification\PlayerBustedSpec;
use Afsy\Blackjack\Domain\Specification\DealerLimitSpec;
use Afsy\Blackjack\Domain\Specification\GetVisibleCardSpec;
use Afsy\Blackjack\Domain\Service\Croupier;

class Game extends AggregateRoot
{
    protected $players;

    protected $discardPile;

    protected $currentPlayerIndex;

    protected $nbPlayers;

    protected $ended;

    protected $winner;

    public function __construct($id)
    {
        $this->setId($id);
    }

    public function start($nbPlayers, $discardPile)
    {
        $players = $this->createPlayers($nbPlayers);
        $visibleCard = new GetVisibleCardSpec();

        for ($i = 0; $i < 2; $i++) {
            foreach ($players as $player) {
                $card = $discardPile->deal(
                    $visibleCard->isSatisfiedBy($player, $i)
                );
                $player->receiveCard($card);
            }
        }

        $this->apply(new GameCreated($this->getId(), $players, $discardPile));
    }

    public function dealCard()
    {
        $player = $this->getCurrentPlayer();
        $player->receiveCard($this->discardPile->deal(true));

        $this->apply(new CardDealt($this->getId(), $player, $this->discardPile));

        $bustedSpec = new PlayerBustedSpec();

        if ($bustedSpec->isSatisfiedBy($player)) {
            $this->apply(new GameOver($this->getId(), $player));
        }

        $dealerSpec = new DealerLimitSpec();

        if ($dealerSpec->isSatisfiedBy($player)) {
            $this->apply(new DealerStopped($this->getId(), $player));
        }
    }

    public function stopDealCard()
    {
        $this->getCurrentPlayer()->stop();
        $this->nextPlayer();

        while ($this->getCurrentPlayer()->isInGame()) {
            $this->deal();
        }
    }

    public function getCurrentPlayer()
    {
        return $this->players[$this->currentPlayerIndex];
    }

    public function nextPlayer()
    {
        $this->currentPlayerIndex += 1;

        if ($this->currentPlayerIndex >= $this->nbPlayers) {
            $this->currentPlayerIndex = 0;
        }

        return $this->currentPlayerIndex;
    }

    public function createPlayers($nbPlayers)
    {
        $players = [];

        for ($i = 0; $i < $nbPlayers; $i++) {
            if (0 == $i) {
                $identity = new PlayerIdentity('Joueur 1', true);
            } else {
                $identity = new PlayerIdentity('Computer '.$i, false);
            }

            $players[] = new Player($identity, new Hand());
        }

        return $players;
    }

    public function verifyWinner()
    {
        // should be injected
        $croupier = new Croupier;
        $this->winner = $croupier->findWinner($this->players);
    }

    protected function applyGameCreated($event)
    {
        $this->nbPlayers = count($event->players);
        $this->players = $event->players;
        $this->currentPlayerIndex = 0;
        $this->discardPile = $event->discardPile;
    }

    protected function applyCardDealt($event)
    {
        $this->discardPile = $event->discardPile;
    }

    protected function applyGameOver($event)
    {
        $event->player->gameOver();
        $this->nextPlayer();
        $this->winner = $this->getCurrentPlayer();
    }

    protected function applyDealerStopped($event)
    {
        $this->verifyWinner();
    }
}
