<?php

namespace App\Cards;

class Card
{
    //private $aCard = array();


    public function __construct(int | string $value = null, string $suit = null, string $color = null, int $point = null)
    {
        $this->value = $value;
        $this->suit = $suit;
        $this->color = $color;
        $this->point = $point;
    }

    public function getPoint() {
        return $this->point;
    }

   

    public function getAsString(): string
    {
        return "{$this->value}, {$this->suit}, {$this->color}";
    }
}
