<?php

namespace App\Card;

use App\Card\Deck;

class DeckWithJoker extends Deck
{
    public function __construct($quantity = 2)
    {
        parent::__construct();
        
        for ($i = 0; $i < $quantity; $i++) {
            $this->deck[] = new Card("joker", "Joker");
        }
    }

    public function addJokers($quantity = 2): void
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->deck[] = new Card("joker", "Joker");
        }
    }
}
