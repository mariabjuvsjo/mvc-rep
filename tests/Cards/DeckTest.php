<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

use App\Cards\Deck;

use App\Cards\Card;

/**
 * Test Cases for class Deck
 */

class DeckTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreate()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Cards\Deck", $deck);
    }

    public function testCountCards()
    {
        $deck = new Deck();

        $res = $deck->countCards();

        $this->assertEquals($res, 52);
    }

    public function testGetDeck() 
    {
        $deck = new Deck();

        $card = new Card(2, "&hearts;", "red", 2);

        $res = $deck->getDeck();
    
        $this->assertEquals($res[1], $card);

        $this->assertIsObject($res[1]);

    }

    public function testShuffleDeck() 
    {
        $deck1 = new Deck();

        $deck2 = new Deck();

        $deck2->shuffles();

        $res1 = $deck1->getDeck();

        $res2 = $deck2->getDeck();

        

        $this->assertNotEquals($res1, $res2);

    }

    public function testDrawCardWithNoArgs()
    {
        $deck1 = new Deck();
        
        $card = new Card("A", "&hearts;", "red", 11);

        $res = $deck1->draw();

      
        $this->assertEquals($res[0], $card);

    }

    public function testDrawCardWithArgs()
    {
        $deck1 = new Deck();
        
        $card = new Card(4, "&hearts;", "red", 4);

        $res = $deck1->draw(4);

        $this->assertEquals($res[3], $card);
        
    }

    public function testDrawExceptionOutofBounds()
    {
        $deck1 = new Deck();

        $this->expectException(DrawException::class);

        $res = $deck1->draw(54);

    }

    public function testDrawExceptionEmpyDeck()
    {
        $deck1 = new Deck();

        $deck1->draw(52);

        $this->expectException(DrawException::class);

        $res = $deck1->draw();

    }
}
