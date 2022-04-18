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

    public function getDeck(): array
    {
        return $this->deck;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function drawCard($quantity = 1): array
    {
        $cards = [];
        
        if (count($this->deck) >= $quantity) {
            $cards = array_splice($this->deck, 0, $quantity);
        } else {
            $cards = array_splice($this->deck, 0, count($this->deck));
        }

        return $cards;
    }

    public function countDeck(): int 
    {
        return count($this->deck);
    }
}
