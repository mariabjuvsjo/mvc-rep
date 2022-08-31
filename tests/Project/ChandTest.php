<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Cdeck;

use App\Project\Ccards;

use App\Project\Chand;


/**
 * Test Cases for class Chand
 */


class ChandTest extends TestCase
{
    /**
     * setup with hand object
     */
    private $hand;

    private $deck;

    protected function setUp(): void
    {
        $this->deck = new Cdeck();
        $this->hand = new Chand($this->deck);
    }

      /**
     * verify that the object is of expected instance.
    */

    public function testCreate()
    {
      
        $this->assertInstanceOf("\App\Project\Chand", $this->hand);
    }

    /*
    * Test to see get hand method return an empty array when called with no other method being called before
    */

   public function testGetHandWEmptyHand()
   {
       

       $res = $this->hand->getHand();

       $this->assertEquals([], $res);
   }
   /*
    * Test to see if the playerhand method returns an array with 2 cards.
    */

    public function testPlayerHand()
    {
        $hand = $this->hand->playerHand();

        $res = $this->hand->getHand();

        

        $this->assertCount(2, $res);
    }



}