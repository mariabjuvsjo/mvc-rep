<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Ccards;

use App\Project\Cdeck;

use App\Project\Chand;

use App\Project\Crules;

use App\Project\CcompareHands;
/**
 * Test Cases for CcompareHands class
 */

class CcompareHandsTest extends TestCase
{


  
    
    private $compare;

    private $game;

    protected function setUp(): void
    {   
        $this->game = new Cgame();
        $this->compare = new CcompareHands($this->game);

    }

        /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCompareConstruct()
    {

        $this->assertInstanceOf("\App\Project\CcompareHands", $this->compare);

        $this->assertIsObject($this->compare);
    }

    /**
     * test to see if right array is returned if a certain rule is true
     */

    public function testCompareRoyalFlush()
    {
        $royalFlush = $this->createMock(Crules::class);

        $royalFlush->method('royalFlush')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $royalFlush);
        $res2 = $check->checkDealer(clone $royalFlush);

        $this->assertEquals($res1, array(10, "Royal Flush"));
        $this->assertEquals($res2, array(10, "Royal Flush"));
        
    }

      /**
     * test to see if right array is returned if a certain rule is true
     */

    public function testComparefStraightFlush()
    {
        $straightFlush = $this->createMock(Crules::class);

        $straightFlush->method('straightFlush')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $straightFlush);
        $res2 = $check->checkDealer(clone $straightFlush);

        $this->assertEquals($res1, array(9, "Straight Flush"));
        $this->assertEquals($res2, array(9, "Straight Flush"));
        
    }

      /**
     * test to see if right array is returned if a certain rule is true
     */

    public function testCompareFourOfAKind()
    {
        $fourOfAKind = $this->createMock(Crules::class);

        $fourOfAKind->method('fourOfAKind')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $fourOfAKind);
        $res2 = $check->checkDealer(clone $fourOfAKind);

        $this->assertEquals($res1, array(8, "Four Of A Kind"));
        $this->assertEquals($res2, array(8, "Four Of A Kind"));
        
    }

      /**
     * test to see if right array is returned if a certain rule is true
     */
    public function testComparefullHouse()
    {
        $fullHouse = $this->createMock(Crules::class);

        $fullHouse->method('fullHouse')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $fullHouse);
        $res2 = $check->checkDealer(clone $fullHouse);

        $this->assertEquals($res1, array(7, "Full House"));
        $this->assertEquals($res2, array(7, "Full House"));
        
    }

      /**
     * test to see if right array is returned if a certain rule is true
     */
    public function testCompareflush()
    {
        $flush = $this->createMock(Crules::class);

        $flush->method('flush')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $flush);
        $res2 = $check->checkDealer(clone $flush);

        $this->assertEquals($res1, array(6, "Flush"));
        $this->assertEquals($res2, array(6, "Flush")); 
    }

         /**
     * test to see if right array is returned if a certain rule is true
     */
    public function testComparestraight()
    {
        $straight = $this->createMock(Crules::class);

        $straight->method('straight')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $straight);
        $res2 = $check->checkDealer(clone $straight);

        $this->assertEquals($res1, array(5, "Straight"));
        $this->assertEquals($res2, array(5, "Straight")); 
    }

           /**
     * test to see if right array is returned if a certain rule is true
     */
    public function testComparethreeOf()
    {
        $threeOfAKind = $this->createMock(Crules::class);

        $threeOfAKind->method('threeOfAKind')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $threeOfAKind);
        $res2 = $check->checkDealer(clone $threeOfAKind);

        $this->assertEquals($res1, array(4, "Three Of A Kind"));
        $this->assertEquals($res2, array(4, "Three Of A Kind")); 
    }

           /**
     * test to see if right array is returned if a certain rule is true
     */
    public function testComparePair()
    {
        $pair = $this->createMock(Crules::class);

        $pair->method('twoPair')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $pair);
        $res2 = $check->checkDealer(clone $pair);

        $this->assertEquals($res1, array(3, "Two Pair"));
        $this->assertEquals($res2, array(3, "Two Pair"));
    }

              /**
     * test to see if right array is returned if a certain rule is true
     */
    public function testCompareOnePair()
    {
        $pair = $this->createMock(Crules::class);

    
        $pair->method('onePair')->willReturn(true);

        $check = new CcompareHands();
        $res1 = $check->checkPlayer(clone $pair);
        $res2 = $check->checkDealer(clone $pair);

        $this->assertEquals($res1, array(2, "One Pair")); 
        $this->assertEquals($res2, array(2, "One Pair")); 
    }

 

}