<?php

namespace App\Cards;

use App\Cards\Card;

class Deck
{
    protected array $suits = ["&hearts;", "&diams;", "&clubs;", "&spades;"];

    protected $values = array(2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, "J"
    => 10, "Q" => 10, "K" => 10, "A" => 11);

    //protected array $points = [11, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 10, 10];

    protected string $color = "";

    protected array $deck = [];

    public int $point = 0;


    public function __construct()
    {
        foreach ($this->suits as $suit) {
            if ($suit == "&hearts;" || $suit == "&diams;") {
                $color = "red";
            } else {
                $color = "black";
            }
            foreach ($this->values as $value => $point) {
                array_push($this->deck, new \App\Cards\Card($value, $suit, $color, $point));
            }
        }
    }

    public function addCard(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function getDeck(): array
    {
        return $this->deck;
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
