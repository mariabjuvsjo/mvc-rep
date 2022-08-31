<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

use App\Cards\Deck;

use App\Cards\Card;

use App\Cards\Player;

use App\Cards\BlackJack;

/**
 * Test Cases for class BlackJAck
 */

class BlackJackTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testBlackJackConstruct()
    {
        $game = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $game);

        $this->assertIsObject($game);
    }

    /**
     * Test to see if firstplay gives the player object 2 cards
     */

    public function testFirstGivePlayer()
    {
        $game = new BlackJack();

        $game->firstPlay();

        $playerCards = $game->getPlayerCards();

        $this->assertEquals(count($playerCards), 2);
    }

    /**
     * Test to see if firstplay gives the dealer object 2 cards
     */

    public function testFirstGiveDealer()
    {
        $game = new BlackJack();

        $game->firstPlay();

        $dealerCards = $game->getDealerCards();

        $this->assertEquals(count($dealerCards), 2);
    }

    /**
     * Test to see if the playerHit method gives the player object 1 card
     */

    public function testHitPlayer()
    {
        $game = new BlackJack();

        $game->playerHit();

        $playerCards = $game->getPlayerCards();

        $this->assertEquals(count($playerCards), 1);
    }

    /**
     * Test to see that an empty string is returned if no cards is drawn
     */

    public function testFirstDrawW0Point()
    {
        $game = new BlackJack();

        $res = $game->checkFirstDraw();


        $this->assertStringContainsString($res, "");
    }

    /**
     * Test to see that string with you busted is return if player gets over 21
     */

    /*public function testPlayerHaveMorethen21()
    {
        $game = new BlackJack();
        $game->playerHit();
        $game->playerHit();
        $game->playerHit();
        $game->playerHit();
        $game->playerHit();
        $game->playerHit();
        $game->playerHit();


        $res = $game->getPlayerScore();

        $res1 = $game->gameStop();

        $this->assertLessThan($res, 21);

        $this->assertStringContainsString($res1, "dealer got Black Jack, Dealer won!");
    }*/

     /**
     * Stub the Player class to assure that BlackJack can be asserted.
     */
    public function testcheckFirstDraw21All()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(21);
        $dealer->method('scores')
            ->willReturn(21);

        $game21 = new BlackJack();
        $game21->player = (clone $player);
        $game21->dealer = clone $dealer;

        $res = $game21->checkFirstDraw();
        $this->assertEquals("You both got Black Jack, its a tie", $res);
    }




    /**
     * Test to see if a int is return when method getDelarscore is called
     */

    public function testGetDealerScoreReturnsInt()
    {
        $game = new BlackJack();

        $game->firstPlay();

        $res = $game->getDealerScore();

        $this->assertIsInt($res);
    }
}
