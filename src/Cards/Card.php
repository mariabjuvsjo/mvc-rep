<?php

namespace App\Cards;


class Card {

    //private $aCard = array();


    public function __construct(int | string $value = null, string $suit = null, string $color = null ) 
    {
        $this->value = $value;
        $this->suit = $suit;
        $this->color = $color;
    }

    public function getAsString(): string{

        return "{$this->value}, {$this->suit}, {$this->color}";
    }

  


}