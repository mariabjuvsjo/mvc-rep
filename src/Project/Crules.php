<?php

namespace App\Project;

use App\Project\Cdeck;
use App\Project\Ccards;
use App\Project\Cplayer;
use App\Project\Cgame;

/**
 *
 *  Class CRules. 
 */

class Crules
{
    protected array $handPoints = [];

    protected array $handSuits = [];

    protected array $hand;

    protected array $ruleList;
    /**
     * Constructor.
     */
    public function __construct(array $hand)
    {
        $this->hand = $hand;

        $this->handPoints = $this->getPointArr();

        $this->handSuits = $this->getSuitArr();

    
    }

    public function getPointArr() {
        foreach($this->hand as $card) {
           array_push($this->handPoints, $card->getPoint());
        }

        return $this->handPoints;
       
    }

    public function getSuitArr() {
        foreach($this->hand as $card) {
           array_push($this->handSuits, $card->getSuit());
        }

        return $this->handSuits;
       
    }


    public function highCard() {
        $cards = $this->handPoints;

        rsort($cards);

        return $cards[0];
    }

    

    public function onePair() {

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 2) {
            
                return true;
            }
        }

    }

    public function twoPair() {
        $countArr = array_count_values($this->handPoints);
        $counter = 0;

        foreach($countArr as $val) {
            if ($val == 2) {
                $counter += 1;
            }
        }

        if ($counter == 2) {
        
            return true;
        }
    }

    public function threeOfAKind(){

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 3) {
              
                return true;
            }
        }


        
    }

    public function straight() {
    
        $cards = array_unique($this->handPoints);

        sort($cards);

        if ($cards[0] == 2 && $cards[1] == 3 && $cards[2] == 4) {
       
                foreach($cards as $key => $value) {
                    if( $value === 14) {
                        $cards[$key] = 1;
                    }
        }}

        rsort($cards);

        $set = array(array_shift($cards)); // start with the first card
        foreach ($cards as $card) {
        $lastCard = $set[count($set)-1];
        if ($lastCard - 1 != $card) {
            // not a chain anymore, "restart" from here
            $set = array($card);
        } else {
            $set[] = $card;
        }
        if (count($set) == 5) {
            break;}}


       

        if (count($set) == 5) {

            return true;
        } 
    }

    public function flush() {

        $cardsSuit = $this->handSuits;

        $countArr = array_count_values($cardsSuit);

        foreach($countArr as $val) {
            if ($val >= 5) {
       
                return true;
            }
        }   
    }

    public function fullHouse() {

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 3 && 2) {
          
                return true;
            }
        } 
      
    }

    public function fourOfAKind(){

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 4) {
          
                return true;
            }
        }   
    }

    public function straightFlush () {
        if ($this->straight() && $this->flush()) {
  
            return true;
        }
    }

    public function royalFlush() {

        $cards = $this->handPoints;

        sort($cards);
        print_r($cards);
        if ($this->straightFlush()) 
        {
            if($cards[6] == 14) {
           
                return true;
            }
            
        }
    }
}

