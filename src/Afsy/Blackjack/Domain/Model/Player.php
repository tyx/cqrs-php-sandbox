<?php

namespace Afsy\Blackjack\Domain\Model;

class Player
{
    protected $identity;

    protected $hand;

    protected $inGame = true;

    protected $gameOver = false;

    public function __construct(PlayerIdentity $identity)
    {
        $this->identity = $identity;
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

    public function isInGame()
    {
        return $this->inGame && !$this->isGameOver();
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
