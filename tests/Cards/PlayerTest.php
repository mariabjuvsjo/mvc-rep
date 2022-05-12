<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

use App\Cards\Deck;

use App\Cards\Card;

use App\Cards\Player;

/**
 * Test Cases for class Player
 */

class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreatePlayer()
    {
        $deck1 = new Deck();
        $player = new Player($deck1);

        $this->assertInstanceOf("\App\Cards\Player", $player);
    }

    /**
     * test to see if the gethand method return an empty array when no other method been called yet
     */

    public function testGetHandPlayer()
    {
        $deck1 = new Deck();
        $player = new Player($deck1);
        $res = $player->getHand();

        $this->assertEquals($res, []);
    }

    /**
     * Test to see that the firstdeal method is pushing 2 cards into array in Player constructor.
     * Checking if the expected card is pushed into hand
     */

    public function testTheFirstDeal()
    {
        $deck1 = new Deck();
        $player = new Player($deck1);
        $card = new Card(2, "&hearts;", "red", 2);
        $player->firstDeal();

        $res = $player->getHand();

        $this->assertEquals(count($res), 2);

        $this->assertEquals($res[1], $card);
    }

    /**
     * test to see if hit method pushes 1 card to players hand array
     */

    public function testTheHitFunction()
    {
        $deck1 = new Deck();
        $player = new Player($deck1);
        $card = new Card("A", "&hearts;", "red", 11);
        $player->hit();

        $res = $player->getHand();

        $this->assertEquals(count($res), 1);

        $this->assertEquals($res[0], $card);
    }

    /**
     * Testing to see that the score method sums the points from all cards
     */

    public function testScore()
    {
        $deck1 = new Deck();
        $player = new Player($deck1);

        $player->firstDeal();
        $player->hit();
        $player->hit();

        $res = $player->scores();

        $this->assertEquals($res, 20);
    }

    /**
     * test to see if scores concider 1 ass nd removes 10 when score is over 21
     */

    public function testScoreW1AssOver21()
    {
        $deck1 = new Deck();
        $player = new Player($deck1);

        $player->firstDeal();
        $player->hit();
        $player->hit();
        $player->hit();

        $res = $player->scores();

        $this->assertEquals($res, 15);
    }

    /**
     * test too see if method scores takes in consider 2 asses when over 21 and removes 10 + 10
     */

    public function testScoreW2AssOver21()
    {
        $deck1 = new Deck();
        $player = new Player($deck1);

        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->hit();


        $res = $player->scores();

        $this->assertEquals($res, 88);
    }
}
