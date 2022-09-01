<?php

namespace App\Cards;

use App\Cards\Deck;
use App\Cards\Card;
use App\Cards\Player;

/**
 * Class Black Jack. Represent the blackJack game. Holds the whole game.
 */
class BlackJack
{
    public object $deck;

    public object $player;

    public object $dealer;

    /**
     * Constructor to create the black jack object.
     */
    public function __construct()
    {
        $this->deck = new Deck();
        $this->deck->shuffles();
        $this->deck->getDeck();
        $this->player = new Player($this->deck);
        $this->dealer = new Player($this->deck);
    }


    /**
     * Method to give both player and dealer their frist 2 cards.
     *
     * @return void
     *
     */
    public function firstPlay(): void
    {
        $this->player->firstDeal();
        $this->dealer->firstDeal();
    }

    /**
     * Method to check if both or 1 player object as black jack
     *
     * @return string
     */
    public function checkFirstDraw(): string
    {
        if ($this->player->scores()  === 21) {
            if ($this->dealer->scores() === 21) {
                return "You both got Black Jack, its a tie";
            }
            return "you won you got Black Jack";
        } elseif ($this->dealer->scores() === 21) {
            return "Dealer won! he got Black Jack";
        }
        return "";
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

    /**
     * Method to give player 1 card.
     *
     * @return void
     */
    public function playerHit(): void
    {
        $this->player->hit();
    }

    /**
     *
     * Method to see hows won the game.
     *
     * The gameStop is called when player decides to stop.
     *
     * The more cards will be drawn if dealer has less the 17 score.
     *
     * After that alot of if statements will check the diffrent conditions
     * to see whos won the game or if there is a tie.
     *
     */
    public function gameStop(): string
    {
        while ($this->dealer->scores() < 17) {
            $this->dealer->hit();
        };

        if ($this->player->scores() === 21) {
            if ($this->dealer->scores() === 21) {
                return "you both got Black Jack, its a tie!";
            }
            return "you got Black Jack, you won!";
        } elseif ($this->dealer->scores() === 21) {
            return "dealer got Black Jack, Dealer won!";
        } elseif ($this->player->scores() === $this->dealer->scores()) {
            return "you both have same score, its a tie!";
        } elseif ($this->player->scores() > 21) {
            return "You busted, Dealer won!";
        } elseif ($this->dealer->scores() > 21) {
            return "Dealer busted, you won!";
        } elseif ((21 - $this->dealer->scores()) < (21 - $this->player->scores())) {
            return "Dealer have higher score, Dealer won!";
        } elseif ((21 - $this->dealer->scores()) > (21 - $this->player->scores())) {
            return "You have the higher score, You won!";
        }
        return "something went wrong!";
    }
}
