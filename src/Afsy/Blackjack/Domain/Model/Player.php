<?php

namespace Afsy\Blackjack\Domain\Model;

use Afsy\Blackjack\Domain\Specification\PlayerBustedSpec;
use Afsy\Blackjack\Domain\Specification\DealerLimitSpec;

class Player
{
    protected $identity;

    protected $hand;

    protected $inGame = true;

    protected $gameOver = false;

    protected $bank = false;

    public function __construct(PlayerIdentity $identity, $bank = false)
    {
        $this->identity = $identity;
        $this->bank = $bank;
        $this->hand = new Hand;
    }

    public function receiveCard(Card $card)
    {
        return $this->hand->receiveCard($card);
    }

    public function getCards()
    {
        return $this->hand->getCards();
    }

    public function getHand()
    {
        return $this->hand;
    }

    public function getScore()
    {
        return $this->hand->getScore();
    }

    public function isHuman()
    {
        return $this->identity->isHuman();
    }

    public function isBank()
    {
        return $this->bank;
    }

    public function isInGame()
    {
        return $this->inGame && !$this->isGameOver();
    }

    public function isBusted()
    {
        $bustedSpec = new PlayerBustedSpec;

        return $bustedSpec->isSatisfiedBy($this);
    }

    public function hasReachedDealerLimits()
    {
        $dealerSpec = new DealerLimitSpec;

        return $dealerSpec->isSatisfiedBy($this);
    }

    public function stop()
    {
        $this->inGame = false;
    }

    public function isGameOver()
    {
        return $this->gameOver;
    }

    public function gameOver()
    {
        $this->gameOver = true;
    }
}
