<?php

namespace Afsy\Blackjack\Domain\Model;

/**
 * Game
 */
class GameView
{
    /**
     * @var integer
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

    /**
     * Set id
     *
     * @param uuid $id
     * @return Game
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set playerCards
     *
     * @param array $playerCards
     * @return Game
     */
    public function setPlayerCards($playerCards)
    {
        $this->playerCards = $playerCards;

        return $this;
    }

    /**
     * Get playerCards
     *
     * @return array
     */
    public function getPlayerCards()
    {
        return $this->playerCards;
    }

    public function addPlayerCard($card)
    {
        $this->playerCards[] = $card;
    }

    /**
     * Set bankCards
     *
     * @param array $bankCards
     * @return Game
     */
    public function setBankCards($bankCards)
    {
        $this->bankCards = $bankCards;

        return $this;
    }

    /**
     * Get bankCards
     *
     * @return array
     */
    public function getBankCards()
    {
        return $this->bankCards;
    }

    public function addBankCard($card)
    {
        $this->bankCards[] = $card;
    }

    /**
     * Set winner
     *
     * @param string $winner
     * @return Game
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }
}
