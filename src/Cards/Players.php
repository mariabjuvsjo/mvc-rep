<?php

namespace App\Cards;

use App\Cards\Hand;

class Players
{
    protected array $players = [];
    protected int $nbPlayers;

    public function __construct(int $nbPlayers = 1)
    {
        $this->nbPlayers = $nbPlayers;

        for ($i = 1; $i <= $this->nbPlayers; $i++) {
            $this->players[$i] = new Hand();
        }
    }
    public function getPlayers(): array
    {
        return $this->players;
    }
}
