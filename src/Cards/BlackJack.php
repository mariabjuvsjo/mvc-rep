<?php

namespace App\Cards;

use App\Cards\Deck;

use App\Cards\Card;

use App\Cards\Player;

class BlackJack {

    public function __construct() {
        $this->deck = new Deck();
        $this->deck->shuffles();
        $this->deck->getDeck();
        $this->player = new Player(True, $this->deck);
        $this->dealer = new Player(False, $this->deck);
    }

    public function firstPlay() {
       $this->player->firstDeal();
        $this->dealer->firstDeal(); 
    }

    public function checkFirstDraw() {
        if ($this->player->scores()  === 21) {
            if ($this->dealer->scores() === 21) {
                return "You both got Black Jack, its a tie";
            }
            return "you won you got Black Jack";
        } else if ($this->dealer->scores() === 21){
            return "Dealer won! he got Black Jack";
        }return "";

    }

    public function getPlayerCards(): array {
        return $this->player->getHand();
    }

    public function getPlayerScore(): int {
        return $this->player->scores();
    }


    public function getDealerCards(): array {
        return $this->dealer->getHand();
    }

    public function getDealerScore(): int {
        return $this->dealer->scores();
    }

    public function playerHit() {
        $this->player->hit();
    }

    public function gameStop() {

        while ($this->dealer->scores() < 17) {
            $this->dealer->hit();
        };

        if ($this->player->scores() === 21) {
            if ($this->dealer->scores()=== 21) {
                return "you both got Black Jack, its a tie!";
            }
            return "you got Black Jack, you won! ";

        } else if ($this->dealer->scores() === 21) {
            return "dealer got Black Jack, Dealer won!";
        }
        else if ($this->player->scores() === $this->dealer->scores()) {
            return "you both have same score, its a tie!";
        }
        else if ($this->player->scores() > 21) {
            return "You busted, Dealer won!";
        } else if ($this->dealer->scores() > 21) {
            return "Dealer busted, you won!";
        } else if ((21 - $this->dealer->scores()) < (21 - $this->player->scores())) {
            return "Dealer have higher score, Dealer won!";
        } else if ((21 - $this->dealer->scores()) > (21 - $this->player->scores())) {
            return "You have the higher score, You won!";
        } else {
            return "something went wrong!";
        }
    }






}
