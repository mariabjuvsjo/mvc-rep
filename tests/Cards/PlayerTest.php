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
        $player = New Player($deck1);

        $this->assertInstanceOf("\App\Cards\Player", $player);
    }

    public function testGetHandPlayer()
    {
        $deck1 = new Deck();
        $player = New Player($deck1);
        $res = $player->getHand();

        $this->assertEquals($res, []);

    }

    public function testTheFirstDeal()
    {
        $deck1 = new Deck();
        $player = New Player($deck1);
        $card = new Card(2, "&hearts;", "red", 2);
        $player->firstDeal();

        $res = $player->getHand();

        $this->assertEquals(count($res), 2);

        $this->assertEquals($res[1], $card);
    }

    public function testTheHitFunction()
    {
        $deck1 = new Deck();
        $player = New Player($deck1);
        $card = new Card("A", "&hearts;", "red", 11);
        $player->hit();

        $res = $player->getHand();

        $this->assertEquals(count($res), 1);

        $this->assertEquals($res[0], $card);
    }

    public function testScore() 
    {

        $deck1 = new Deck();
        $player = New Player($deck1);

        $player->firstDeal();
        $player->hit();
        $player->hit();

        $res = $player->scores();

        $this->assertEquals($res, 20);
    }

    public function testScoreW1AssOver21()
    {
        $deck1 = new Deck();
        $player = New Player($deck1);

        $player->firstDeal();
        $player->hit();
        $player->hit();
        $player->hit();

        $res = $player->scores();

        $this->assertEquals($res, 15);    
    }

    public function testScoreW2AssOver21()
    {
        $deck1 = new Deck();
        $player = New Player($deck1);

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