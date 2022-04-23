<?php

namespace App\Cards;

use App\Cards\Card;

class Deck
{
    private array $deck = [];


    public function addCard(Card $card): void
    {
        $this->deck[] = $card;
    }


    public function getDeck(): array
    {
        return($this->deck);
    }

    public function shuffles(): void
    {
        shuffle($this->deck);
    }

    public function draw($cards = 1): array
    {
        $hand = [];
        if (count($this->deck) > 0) {
            for ($i = 0; $i <= $cards - 1; $i++) {
                $hand[] = $this->deck[0];
                $newDeck = array_shift($this->deck);
            }
        }

        return $hand;
    }

    public function countCards(): int
    {
        $numCards = count($this->deck);

        return $numCards;
    }



    public function getAsArray(): array
    {
        $arri = array();
        foreach ($this->deck as $card) {
            $arri[] = $card->getAsString();
        }
        return $arri;
    }
}
