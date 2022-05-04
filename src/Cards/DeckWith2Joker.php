<?php

namespace App\Cards;

use App\Cards\Card;

class DeckWith2Joker extends Deck
{ 
    public function __construct()
    {
        parent::__construct();

        array_push($this->deck, new \App\Cards\Card("J", "&#127199;", "black"));
        array_push($this->deck, new \App\Cards\Card("J", "&#127199;", "red"));
    }


  }