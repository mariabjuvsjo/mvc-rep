<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

use App\Cards\Hand;

use App\Cards\Players;

/**
 * Test Cases for class Player
 */

class Kmom02PlayersTest extends TestCase
{
        /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreatePlayer()
    {   
        $players = new Players();
      
        $this->assertInstanceOf("\App\Cards\Players", $players);
    }

    public function testPlayersWithNoArgs()
    {
        $players = new Players();

        $res = $players->getPlayers();

        $this->assertEquals(count($res), 1);

    }

    public function testPlayersWithArgs()
    {
        $players = new Players(5);

        $res = $players->getPlayers();

        $this->assertEquals(count($res), 5);

    }

}