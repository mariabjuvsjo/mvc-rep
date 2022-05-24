<?php

namespace App\Project;

use App\Project\CDeck;
use App\Project\Ccards;

/**
 *
 *  Class Cplayer. Represent a player or dealer
 */

class Cplayer
{
    protected array $hand;

    public object $deck;

    public int $score;

    /**
     * Constructor. Creates the player with an empty array as a hand. And a start score set to 0.
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
        $this->hand = array_merge($this->hand, $this->deck->draw(5));
    }

    public function dealerFirstDeal(): void
    {
        $this->hand = array_merge($this->hand, $this->deck->draw(1));
    }

    public function dealerSecondDeal(): void
    {
        $this->hand = array_merge($this->hand, $this->deck->draw(4));
    }


}