<?php

namespace App\Cards;

class Hand
{
    protected array $hand;

    public function __construct()
    {
        $this->hand = [];
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function addCardTHand(array $card): void
    {
        $this->hand[] = $card;
    }
}
