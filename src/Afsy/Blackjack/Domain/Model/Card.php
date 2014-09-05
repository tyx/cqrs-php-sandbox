<?php

namespace Afsy\Blackjack\Domain\Model;

class Card
{
    protected $color;

    protected $name;

    protected $points;

    protected $upturned;

    public function __construct($color, $name, $points, $upturned = false)
    {
        $this->color = $color;
        $this->name = $name;
        $this->points = $points;
        $this->upturned = $upturned;
    }

    public function upturn()
    {
        $this->upturned = true;
    }

    public function isIdenticalTo($card)
    {
        return $card->isColored($this->color) && $card->isNamed($this->name);
    }

    public function isColored($color)
    {
        return $this->color === $color;
    }

    public function isNamed($name)
    {
        return $this->name === $name;
    }

    public function isUpturned()
    {
        return true === $this->upturned;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPoints()
    {
        // Even Card can have multiple values, for now we consider there is only one
        return current($this->points);
    }
}
