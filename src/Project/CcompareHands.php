<?php

namespace App\Project;

use App\Project\Cdeck;
use App\Project\Ccards;
use App\Project\Cplayer;

/**
 * Class CcompareHands. class to see who have strongest hand.
 */
class CcompareHands {


    public function __construct(Cgame $game){

        $playerHand = $game->playerFullHand();


    }
}