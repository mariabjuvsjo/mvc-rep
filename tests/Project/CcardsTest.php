<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Ccards;

/**
 * Test Cases for class Card
 */

class CcardsTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreate()
    {
        $card = new Ccards("Q", "&hearts;", "red", 10);
        $this->assertInstanceOf("\App\Project\Ccards", $card);
    }

    /**
     * Construct object and check if a point is returned
     */

    public function testPointMethodWhenPointIsGiven()
    {
        $card = new Ccards("Q", "@hearts;", "red", 10);
        $res = $card->getPoint();
        $this->assertEquals(10, $res);
    }

    /**
     * Construct object and check if a default point is returned when non is given
     */

    public function testPointIsDefaultZero()
    {
        $card = new Ccards("Q", "@hearts;", "red");
        $res = $card->getPoint();
        $this->assertEquals(0, $res);
    }

    public function testGetSuitMethod()
    {
        $card = new Ccards("K", "&clubs;", "red", 13);
        $res = $card->getSuit();
        $this->assertEquals("&clubs;", $res);

    }
}