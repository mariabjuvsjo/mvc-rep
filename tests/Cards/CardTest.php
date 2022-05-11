<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

use App\Cards\Card;

/**
 * Test Cases for class Card
 */

class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreate()
    {
        $card = new Card("Q", "&hearts;", "red", 10);
        $this->assertInstanceOf("\App\Cards\Card", $card);
    }

    /**
     * Construct object and check if a point is returned
     */

    public function testPointMethodWhenPointIsGiven() {
        $card = new Card("Q", "@hearts;", "red", 10);
        $res = $card->getPoint();
        $this->assertEquals(10, $res);
    }

    /**
     * Construct object and check if a default point is returned when non is given
     */

    public function testPointIsDefaultZero() {
        $card = new Card("Q", "@hearts;", "red");
        $res = $card->getPoint();
        $this->assertEquals(0, $res);
    }

    /**
     * Construct object and check if string method returns string with properties in
     */

    public function testGetStringBack() 
    {
        $card = new Card("Q", "@hearts;", "red", 10);
        $res = $card->getAsString();

        $this->assertStringContainsString("@hearts;", $res);


    }
      
}