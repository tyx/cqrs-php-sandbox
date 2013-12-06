<?php

namespace Afsy\Domain\Blackjack\Model;

class Player
{
    protected $identity;

    protected $hand;

    protected $inGame = true;

    protected $gameOver = false;

    public function __construct(PlayerIdentity $identity, Hand $hand)
    {
        $this->identity = $identity;
        $this->hand = $hand;
    }

    public function receiveCards($cards)
    {
        return $this->hand->receiveCards($cards);
    }

    public function getCards()
    {
        return $this->hand->getCards();
    }

    public function getPoints()
    {
        return $this->hand->getPoints();
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