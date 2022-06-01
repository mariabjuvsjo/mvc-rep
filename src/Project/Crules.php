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
    protected array $handPoints;

    protected array $handSuit;
    /**
     * Constructor.
     */
    public function __construct(array $handPoints, array $handSuit)
    {
        $this->handPoints = $handPoints;
        $this->handSuit = $handSuit;
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
                echo("onepair");
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
            echo("twopair");
            return true;
        }
    }

    public function threeOfAKind(){

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 3) {
                echo("threeof a kind");
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
            echo "Found a straight with ".implode(',', $set)."\n";
            return true;
        } 
    }

    public function flush() {

        $cardsSuit = $this->handSuit;

        $countArr = array_count_values($cardsSuit);

        foreach($countArr as $val) {
            if ($val >= 5) {
                echo("flush");
                return true;
            }
        }   
    }

    public function fullHouse() {

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 3 && 2) {
                echo("full house");
                return true;
            }
        } 
      
    }

    public function fourOfAKind(){

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 4) {
                echo("fourof a kind");
                return true;
            }
        }   
    }

    public function straightFlush () {
        if ($this->straight() && $this->flush()) {
            echo("hello");
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
                echo("royalFlush");
                return true;
            }
            
        }
    }
}

$rule = new Crules(array(8, 5, 9, 7, 6, 4, 3), array("&hearts;", "&hearts;", "&hearts;", "&hearts;", "&hearts;", "&diamond;", "&diamond;"));

$rule->straight();