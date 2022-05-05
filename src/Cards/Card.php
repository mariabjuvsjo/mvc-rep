<?php

namespace App\Cards;

class Card
{
    public mixed $value;
    public string $suit;
    public string $color;
    public int $point;

    public function __construct(int | string $value, string $suit, string $color, int $point = 0)
    {
        $this->value = $value;
        $this->suit = $suit;
        $this->color = $color;
        $this->point = $point;
    }

    public function getPoint()
    {
        return $this->point;
    }



    public function getAsString(): string
    {
        return "{$this->value}, {$this->suit}, {$this->color}";
    }
}
