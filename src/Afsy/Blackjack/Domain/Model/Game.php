<?php

namespace Afsy\Blackjack\Domain\Model;

use LiteCQRS\AggregateRoot;
use Rhumsaa\Uuid\Uuid;

use Afsy\Blackjack\Domain\Event\CardDealt;
use Afsy\Blackjack\Domain\Event\GameCreated;
use Afsy\Blackjack\Domain\Event\GameOver;
use Afsy\Blackjack\Domain\Event\DealerStopped;
use Afsy\Blackjack\Domain\Service\Croupier;

class Game extends AggregateRoot
{
    protected $players;

    protected $discardPile;

    protected $currentPlayerIndex;

    protected $nbPlayers;

    protected $ended;

    protected $winner;

    protected $round;

    public function __construct(Uuid $id)
    {
        $this->setId($id);
    }

    public function start(array $players, DiscardPile $discardPile)
    {
        $this->round = 0;
        $nbCardsToDistribute = 2;

        $this->distributeCards($discardPile, $players, $nbCardsToDistribute);

        $this->apply(new GameCreated($players, $discardPile, $this->round));
    }

    public function dealCard()
    {
        $this->guardGameIsStarted();

        $player = $this->getCurrentPlayer();
        $this->discardPile->dealToPlayer($player, $this->round);
        $this->round++;

        $this->apply(new CardDealt($this->getId(), $player, $this->discardPile, $this->round));

        if ($player->isBusted()) {
            $this->apply(new GameOver($this->getId(), $player));
        }

        if ($player->hasReachedDealerLimits()) {
            $this->apply(new DealerStopped($this->getId(), $player));
        }
    }

    public function stopDealCard()
    {
        $this->getCurrentPlayer()->stop();
        $this->nextPlayer();

        while ($this->getCurrentPlayer()->isInGame()) {
            $this->dealCard();
        }
    }

    public function getCurrentPlayer()
    {
        return $this->players[$this->currentPlayerIndex];
    }

    public function verifyWinner()
    {
        // should be injected
        $croupier = new Croupier;
        $this->winner = $croupier->findWinner($this->players);
    }

    protected function applyGameCreated(GameCreated $event)
    {
        $this->nbPlayers = count($event->players);
        $this->players = $event->players;
        $this->currentPlayerIndex = 0;
        $this->discardPile = $event->discardPile;
        $this->round = $event->round;
    }

    protected function applyCardDealt(CardDealt $event)
    {
        $this->discardPile = $event->discardPile;
        $this->round = $event->round;
    }

    protected function applyGameOver(GameOver $event)
    {
        $event->player->gameOver();
        $this->nextPlayer();
        $this->winner = $this->getCurrentPlayer();
    }

    protected function applyDealerStopped(DealerStopped $event)
    {
        $this->verifyWinner();
    }

    private function nextPlayer()
    {
        $this->currentPlayerIndex += 1;

        if ($this->currentPlayerIndex >= $this->nbPlayers) {
            $this->currentPlayerIndex = 0;
        }

        return $this->currentPlayerIndex;
    }

    private function distributeCards(DiscardPile $discardPile, array $players, $nbCards)
    {
        for ($i = 0; $i < $nbCards; $i++) {
            foreach ($players as $player) {
                $discardPile->dealToPlayer($player, $this->round);
            }
            $this->round++;
        }
    }

    private function guardGameIsStarted()
    {
        if (null === $this->discardPile || null === $this->players) {
            throw new \LogicException('Game should be started.');
        }
    }
}
