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

    public function fourOfAKind(){

        $countArr = array_count_values($this->handPoints);

        foreach($countArr as $val) {
            if ($val == 4) {
                echo("fourof a kind");
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

    public function straight() {
        $cards = array_unique($this->handPoints);
        $lenCard = count($cards);

        if($lenCard != 5) {
            return false;
        }

        sort($cards);

        if ($cards[0] == 2 && $cards[4] == 14) {
            $replacements = array(4 => 1);
            $cards = array_replace($cards, $replacements);
        }

        sort($cards);

        for ($i = 0; $i < $lenCard -1; $i++) {
            if($cards[$i] +1 != $cards[$i +1]){
                return false;
            }
        }
       
        return true;
    }

    public function flush() {

        $cardsSuit = array_unique($this->handSuit);

        $cardSuitLen = count($cardsSuit);

        if ($cardSuitLen == 1) {
            //echo("flush");
            return true;
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
            if($cards[4] == 14) {
                echo("royalFlush");
                return true;
            }
            
        }
    }

    

}

$rule = new Crules(array(9, 12, 13, 11, 10), array("&hearts;", "&hearts;", "&hearts;", "&hearts;"));

$rule->royalFlush();