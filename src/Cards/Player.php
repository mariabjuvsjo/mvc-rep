<?php

namespace App\Cards;

use App\Cards\Deck;

use App\Cards\Card;

class Player {

    protected array $hand;

    public object $deck;

    public int $score;


    public function __construct( Deck $deck) {

        $this->hand = [];
        $this->deck = $deck;

        $this->score = 0;
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function firstDeal(): void {
        $this->hand = array_merge($this->hand, $this->deck->draw(2));    
    }

    public function hit(): void {
        $this->hand = array_merge($this->hand, $this->deck->draw(1));
     
    }

    public function scores(): int{
        $assCounter = 0;

        $this->score = 0;

        foreach($this->hand as $card) {
            if ($card->getPoint() === 11) {
                $assCounter += 1;
            }
            $this->score += $card->getPoint();
        }
        while ($assCounter != 0 && $this->score > 21) {
            $assCounter -= 1;
            $this->score -= 10;
        }
        return $this->score;
    }

    

    



   

    


   

}