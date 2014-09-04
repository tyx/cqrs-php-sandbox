<?php

namespace Afsy\Blackjack\Domain\Model;

/**
 * Game
 */
class GameView
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $playerCards;

    /**
     * @var array
     */
    private $bankCards;

    /**
     * @var string
     */
    private $winner;

    public function __construct($id, array $players)
    {
        $this->id = $id;

        foreach ($players as $player) {
            $this->distributeCards($player);
        }
    }

    public function distributeCards(Player $player)
    {
        $cards = $player->getCards();

        if ($player->isHuman()) {
            $this->playerCards = $cards;
        } else {
            $this->bankCards = $cards;
        }
    }

    public function award($winner)
    {
        $this->winner = $winner;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getPlayerCards()
    {
        return $this->playerCards;
    }

    /**
     * @return array
     */
    public function getBankCards()
    {
        return $this->bankCards;
    }

    /**
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }
}
