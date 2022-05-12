<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

use App\Cards\Hand;

use App\Cards\Deck;

use App\Cards\Card;

/**
 * Test Cases for class Hand
 */

class HandTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreateHand()
    {
        $hand = new Hand();
        $this->assertInstanceOf("\App\Cards\Hand", $hand);
    }

    /**
     * Test to see get hand method return an empty array when called with no other method being called before
     */

    public function testGetHandWEmptyHand()
    {
        $hand = new Hand();

        $res = $hand->getHand();

        $this->assertEquals([], $res);
    }

    /**
     * Test to see if assCardtoHand works accordingly
     */

    public function testGetHand1Card()
    {
        $hand = new Hand();

        $deck1 = new Deck();

        $card = $deck1->draw();

        $card2 = new Card("A", "&hearts;", "red", 11);

        $hand->addCardTHand($card);

        $res = $hand->getHand();

        $this->assertEquals($res[0][0], $card2);
    }
}
