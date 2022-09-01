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
     * test to see if player winns on fisrt draw
     */
    public function testcheckFirstDraw21Player()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(21);
        $dealer->method('scores')
            ->willReturn(20);

        $game21 = new BlackJack();
        $game21->player = (clone $player);
        $game21->dealer = clone $dealer;

        $res = $game21->checkFirstDraw();
        $this->assertEquals("you won you got Black Jack", $res);
    }

         /**
     * test to see if dealer winns on fisrt draw
     */
    public function testcheckFirstDraw21Dealer()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(5);
        $dealer->method('scores')
            ->willReturn(21);

        $game21 = new BlackJack();
        $game21->player = clone $player;
        $game21->dealer = clone $dealer;

        $res = $game21->checkFirstDraw();
        $this->assertEquals('Dealer won! he got Black Jack', $res);
    }

         /**
     * test to check when player gets 21 and dealer less then 21 on second draw
     */
    public function testCheckPlayerwins()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(21);
        $dealer->method('scores')
            ->willReturn(20);

        $game21 = new BlackJack();
        $game21->player = (clone $player);
        $game21->dealer = (clone $dealer);

        $res = $game21->gameStop();

        $this->assertEquals("you got Black Jack, you won!", $res);
    }

      /**
     * Test to see if a int is return when method getPlayerscore is called
     */

    public function testGetPlayerScoreReturnsInt()
    {
        $game = new BlackJack();

        $game->firstPlay();

        $res = $game->getPlayerScore();

        $this->assertIsInt($res);
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

         /**
     * test to see when both get 21 on the second draw
     */
    public function testGameStopBoth21()
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

        $res = $game21->gameStop();
        $this->assertEquals("you both got Black Jack, its a tie!", $res);
    }

     /**
     * test to see if dealer winns on game stop
     */
    public function testcheckGamestop21Dealer()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(30);
        $dealer->method('scores')
            ->willReturn(21);

        $game21 = new BlackJack();
        $game21->player = (clone $player);
        $game21->dealer = clone $dealer;

        $res = $game21->gameStop();
        $this->assertEquals('dealer got Black Jack, Dealer won!', $res);
    }

}
