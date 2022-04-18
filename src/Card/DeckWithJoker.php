<?php

namespace App\Card;

use App\Card\Deck;

class DeckWithJoker extends Deck
{
    public function addJokers($quantity = 2): void
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->deck[] = new Card("joker", "Joker");
        }
    }
}
