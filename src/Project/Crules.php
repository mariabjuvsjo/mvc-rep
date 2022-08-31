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

        $pointHand = [];
        foreach($this->hand as $card) {
           array_push($pointHand, $card->getPoint());
        }

        return $pointHand;
       
    }

    public function getSuitArr() {

        
        $suitHand = [];
        foreach($this->hand as $card) {
           array_push($suitHand, $card->getSuit());
        }

        return $suitHand;
       
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

        return false;

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

        return false;
    }

    public function threeOfAKind(){

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 3) {
              
                return true;
            }
        }

        return false;


        
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

        return false;
    }

    public function flush() {

        $cardsSuit = $this->handSuits;

        $countArr = array_count_values($cardsSuit);

        foreach($countArr as $val) {
            if ($val >= 5) {
       
                return true;
            }
        } 
        
        return false;
    }

    public function fullHouse() {

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 3 && 2) {
          
                return true;
            }
        } 

        return false;
      
    }

    public function fourOfAKind(){

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 4) {
          
                return true;
            }
        }   

        return false;
    }

    public function straightFlush () {
        if ($this->straight() && $this->flush()) {
  
            return true;
        }

        return false;
    }

    public function royalFlush() {

        $cards = $this->handPoints;

        rsort($cards);
        //print_r($cards);
        if ($this->straightFlush()) 
        {
            if($cards[0] == 14) {
           
                return true;
            }
            
        }

        return false;
    }
}

