<?php

namespace Afsy\Domain\Blackjack\Model;

use LiteCQRS\AggregateRoot;

use Afsy\Domain\Blackjack\Event\CardDealt;
use Afsy\Domain\Blackjack\Event\GameCreated;
use Afsy\Domain\Blackjack\Event\GameOver;
use Afsy\Domain\Blackjack\Event\DealerStopped;
use Afsy\Domain\Blackjack\Specification\PlayerBustedSpec;
use Afsy\Domain\Blackjack\Specification\DealerLimitSpec;
use Afsy\Domain\Blackjack\Specification\GetVisibleCardSpec;

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
                $player->receiveCards([$card]);
            }
        }

        $this->apply(new GameCreated($this->getId(), $players, $discardPile));
    }

    public function deal()
    {
        $player = $this->getCurrentPlayer();
        $player->receiveCards(array($this->discardPile->deal(true)));

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

    public function stop()
    {
        $player = $this->getCurrentPlayer();
        $player->stop();
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
        $max = 0;

        foreach ($this->players as $index => $player) {
            if ($player->getPoints() > $max) {
                $max = $player->getPoints();
                $this->winner = $player;
            }
        }

        return $this->winner;
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