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

    public function testPlayerHaveMorethen21()
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

        $this->assertStringContainsString($res1, "You busted, Dealer won!");
    }

    public function testPlayerHaveMorethenDealer()
    {
        $game = new BlackJack();

        $game->firstPlay();
        $game->playerHit();
        $game->playerHit();
        $game->playerHit();
        $game->playerHit();


        $res = $game->getPlayerScore();

        $res1 = $game->gameStop();

        $this->assertLessThan($res, 21);

        //$this->assertStringContainsString($res1, "You busted, Dealer won!");
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
