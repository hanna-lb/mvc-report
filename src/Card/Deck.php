<?php

namespace App\Card;

use App\Card\Card;

class Deck
{
    protected $colours = ["spades", "hearts", "clubs", "diamonds"];
    protected $values = ["E", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Kn", "D", "K"];
    protected $deck = [];

    public function __construct()
    {
        foreach ($this->colours as $colour) {
            foreach ($this->values as $value) {
                $this->deck[] = new Card($colour, $value);
            }
        }
    }

    public function getDeck()
    {
        return $this->deck;
    }

    public function shuffle()
    {
        shuffle($this->deck);
    }
}
