<?php

namespace App\Project;

use App\Project\Cdeck;
use App\Project\Ccards;
use App\Project\Cplayer;

/**
 * Class Cgame. Represent the Texas poker game. Holds the whole game.
 */
class Cgame
{
    public object $deck;

    public object $player;

    public object $dealer;

    private array $community;

    private int $thePot;

    /**
     * Constructor to create the Cgame object.
     */
    public function __construct()
    {
        $this->deck = new Cdeck();
        $this->deck->shuffles();
        $this->deck->getDeck();
        $this->player = new Chand($this->deck);
        $this->dealer = new Chand($this->deck);
        $this->community = [];
        $this->playerHand = [];
        $this->dealerHand = [];
        $this->thePot = 0;
    }

    /**
     * Method to give both player and dealer their frist 2 cards.
     *
     * @return void
     *
     */
    public function firstPlay(): void
    {
        $this->player->playerHand();
        $this->dealer->playerHand();
    }

    public function getPlayerCard(): array {
        return $this->player->getHand();
    }
  
    public function getDealerCard(): array {
        return $this->dealer->getHand();
    }

    public function getCommunityCards(): array {
        return $this->community;
    }

    public function theFlop(): void {

        $this->community = array_merge($this->community, $this->deck->draw(3));

    }

    public function turn(): void {

        $this->community = array_merge($this->community, $this->deck->draw(1));
    }

    public function river(): void {

        $this->community = array_merge($this->community, $this->deck->draw(1));

    }

    public function playerFullHand(): array {

        $this->playerHand = array_merge($this->community, $this->getPlayerCard());

        return $this->playerHand;

    }

    public function dealerFullHand(): array {

        $this->dealerHand = array_merge($this->community, $this->getDealerCard());

        return $this->dealerHand;

    }

    public function setPot(int $money): void {
        $this->thePot += $money;

    }

    public function getPot(): int {
        return $this->thePot;
    }

    public function resetPot(): void {
        $this->thePot = 0;

    }

  
}
