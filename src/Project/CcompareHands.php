<?php

namespace App\Project;

use App\Project\Cdeck;
use App\Project\Ccards;
use App\Project\Cplayer;
use App\Project\Crules;
use App\Project\CplayerBal;

/**
 * Class CcompareHands. class to see who have strongest hand.
 */
class CcompareHands
{
    private array $playerHand;

    private array $dealerHand;

    public object $game;


    /**
     * Constructor to create the game object
     *
     *
     */

    public function __construct(Cgame $game)
    {

        $this->game = $game;
        $this->playerHand = $game->playerFullHand();
        $this->dealerHand = $game->dealerFullHand();
        //$this->dealer = $this->checkDealer();
    }

    /**
     * method to check what kind of hand the player has
     *
     * @return array with a number and a string with the right rule name
     */

    public function checkPlayer(): array
    {
        $rule = new Crules($this->playerHand);

        if ($rule->royalFlush()) {
            return [10, "Royal Flush"];
        } elseif ($rule->straightFlush()) {
            return [9, "Straight Flush"];
        } elseif ($rule->fourOfAKind()) {
            return [8, "Four Of A Kind"];
        } elseif ($rule->fullHouse()) {
            return [7, "Full House"];
        } elseif ($rule->flush()) {
            return [6, "Flush"];
        } elseif ($rule->straight()) {
            return [5,"Straight"];
        } elseif ($rule->threeOfAKind()) {
            return [4,"Three Of A Kind"];
        } elseif ($rule->twoPair()) {
            return [3,"Two Pair"];
        } elseif ($rule->onePair()) {
            return [2,"One Pair"];
        }
        return [1, "High Card", $rule->highCard()];
    }

        /**
     * method to check what kind of hand the dealer has
     *
     * @return array with a number and a string with the right rule name
     */

    public function checkDealer(): array
    {
        $rule = new Crules($this->dealerHand);


        if ($rule->royalFlush()) {
            return [10, "Royal Flush"];
        } elseif ($rule->straightFlush()) {
            return [9, "Straight Flush"];
        } elseif ($rule->fourOfAKind()) {
            return [8, "Four Of A Kind"];
        } elseif ($rule->fullHouse()) {
            return [7, "Full House"];
        } elseif ($rule->flush()) {
            return [6, "Flush"];
        } elseif ($rule->straight()) {
            return [5,"Straight"];
        } elseif ($rule->threeOfAKind()) {
            return [4,"Three Of A Kind"];
        } elseif ($rule->twoPair()) {
            return [3,"Two Pair"];
        } elseif ($rule->onePair()) {
            return [2,"One Pair"];
        }

        return [1, "High Card", $rule->highCard()];
    }

    /**
     * method to campare the 2 diffrent arrays from check player and check dealer
     *
     *
     */

    public function compareHand()
    {

        $dealer = $this->checkDealer();
        $player = $this->checkPlayer();
        if ($dealer[0] > $player[0]) {
            return "You lost with " . $player[1] . " Dealer have " . $dealer[1];
        }
        if ($dealer[0] < $player[0]) {
            return "You won with " . $player[1] . " Dealer have " . $dealer[1];
        }

        //if both dealer and player haver high card. See whos high card is highest
        if ($dealer[0] == 1 && $player[0] == 1) {
            if ($dealer[2] > $player[2]) {
                return "You lost. Dealer have" . $dealer[1];
            }
            if ($dealer[2] < $player[2]) {
                return "You won with " . $player[1];
            }
        }

        //if dealer and player have same hand.
        //TODO: Would like implement to compare same hands.
        //who have the hisghet 1 pair for exampel. Until next time
        if ($dealer[0] == $player[0]) {
            return "No one win its a Draw";
        }
    }
}
