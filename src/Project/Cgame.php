<?php

namespace App\Project;

use App\Project\Cdeck;
use App\Project\Ccards;
use App\Project\Cplayer;

/**
 * Class Cgame. Represent the Caribiean poker game. Holds the whole game.
 */
class Cgame
{
    public object $deck;

    public object $player;

    public object $dealer;

    /**
     * Constructor to create the Cgame object.
     */
    public function __construct()
    {
        $this->deck = new Cdeck();
        $this->deck->shuffles();
        $this->deck->getDeck();
        $this->player = new Cplayer($this->deck);
        $this->dealer = new Cplayer($this->deck);
    }


    /**
     * Method to give player his 5 cards and dealer first card
     *
     * @return void
     *
     */
    public function firstPlay(): void
    {
        $this->player->playerHand();
        $this->dealer->dealerFirstDeal();
    }

    public function lastPlay(): void {
        $this->dealer->dealerSecondDeal();

    }

    /**
     *
     * Get method to get players cards.
     *
     * @return array with the players cards.
     *
     */
    public function getPlayerCards(): array
    {
        return $this->player->getHand();
    }

    /**
     *
     * Get method to get players score.
     *
     * @return int with the players score.
     *
     */
    public function getPlayerScore(): int
    {
        return $this->player->scores();
    }

    /**
     *
     * Get method to get dealers cards.
     *
     * @return array with the dealers cards.
     *
     */
    public function getDealerCards(): array
    {
        return $this->dealer->getHand();
    }

    /**
     *
     * Get method to get dealers score.
     *
     * @return int with the dealers score.
     *
     */
    public function getDealerScore(): int
    {
        return $this->dealer->scores();
    }

  
}
