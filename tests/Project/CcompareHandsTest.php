<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Ccards;

use App\Project\Cdeck;

use App\Project\Chand;

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



 

}