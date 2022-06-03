<?php

namespace App\Project;

use App\Project\Cdeck;
use App\Project\Ccards;
use App\Project\Cplayer;
use App\Project\Crules;

/**
 * Class CcompareHands. class to see who have strongest hand.
 */
class CcompareHands {

    private array $playerHand;

    private array $dealerHand;




    public function __construct(Cgame $game){

        $this->game = $game;
        $this->playerHand = $game->playerFullHand();
        $this->dealerHand = $game->dealerFullHand();
    }

    public function checkPlayer() {
        $rule = new Crules($this->playerHand);

        if ($rule->royalFlush()) {
            return 10;
        } elseif ($rule->straightFlush()) {
            return 9;
        } elseif ($rule->fourOfAKind()) {
            return 8;
        } elseif ($rule->fullHouse()) {
            return 7;
        } elseif ($rule->flush()) {
            return 6;
        } elseif ($rule->straight()) {
            return 5;
        } elseif ($rule->threeOfAKind()) {
            return 4;
        } elseif ($rule->twoPair()) {
            return 3;
        } else if ($rule->onePair()) {
            return 2;
        } else {
            return $rule->highCard();
        }
    }

    public function checkDealer() {
        $rule = new Crules($this->dealerHand);

        if ($rule->royalFlush()) {
            return 10;
        } elseif ($rule->straightFlush()) {
            return 9;
        } elseif ($rule->fourOfAKind()) {
            return 8;
        } elseif ($rule->fullHouse()) {
            return 7;
        } elseif ($rule->flush()) {
            return 6;
        } elseif ($rule->straight()) {
            return 5;
        } elseif ($rule->threeOfAKind()) {
            return 4;
        } elseif ($rule->twoPair()) {
            return 3;
        } else if ($rule->onePair()) {
            return 2;
        } else {
            return $rule->highCard();
        }
    }


}