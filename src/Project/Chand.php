<?php

namespace App\Project;

use App\Project\Cdeck;
use App\Project\Ccards;

/**
 *
 *  Class Chand. Represent a hand in texas holdem
 */

class Chand
{
    protected array $hand;

    public object $deck;

  

    /**
     * Constructor. Creates the player with an empty array as a hand.and finally yhe 5 card hand
     */
    public function __construct(Cdeck $deck)
    {
        $this->hand = [];
        $this->deck = $deck;
    }

    /**
     * Method to return the player or dealers card.
     *
     * @return array $hand.
     *
     */

    public function getHand(): array
    {
        return $this->hand;
    }


    public function playerHand(): void
    {
        $this->hand = array_merge($this->hand, $this->deck->draw(2));
    }


}