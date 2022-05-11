<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

use App\Cards\DeckWith2Joker;

use App\Cards\Card;

/**
 * Test Cases for class DeckWith2Joker
 */

class DeckWJokerTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreateDeckWJoker()
    {
        $deck = new DeckWith2Joker();
        $this->assertInstanceOf("\App\Cards\DeckWith2Joker", $deck);
    }

    public function testCountCardsWithJoker()
    {
        $deck = new DeckWith2Joker();

        $res = $deck->countCards();

        $this->assertEquals($res, 54);
    }

    public function testGetDeck() 
    {
        $deck = new DeckWith2Joker();

        $cardBlack = new Card("J", "&#127199;", "black");

        $card = new Card("J", "&#127199;", "red");

        $res = $deck->getDeck();

        $this->assertEquals($res[52], $cardBlack);
    
        $this->assertEquals($res[53], $card);

        $this->assertIsObject($res[53]);

    }

    public function testShuffleDeck() 
    {
        $deck1 = new DeckWith2Joker();

        $deck2 = new DeckWith2Joker();

        $deck2->shuffles();

        $res1 = $deck1->getDeck();

        $res2 = $deck2->getDeck();

        

        $this->assertNotEquals($res1, $res2);

    }

    
}
