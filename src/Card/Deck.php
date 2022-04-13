<?php

namespace App\Card;

use App\Card\Card;

class Deck
{
    protected $colours = ["spades", "hearts", "clubs", "diamonds"];
    protected $values = ["E", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Kn", "D", "K"];
    protected $cards = [];

    public function __construct()
    {
        foreach ($this->colours as $colour) {
            foreach ($this->values as $value) {
                $this->cards[] = new Card($colour, $value);
            }
        }
    }

    public function getDeck()
    {
        return $this->cards;
    }
}
