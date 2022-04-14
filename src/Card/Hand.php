<?php

namespace App\Card;

use App\Card\Card;

class Hand
{
    protected $hand = [];

    public function addCard(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function addCards(Deck $cards)
    {
        $this->hand[] = $cards;

        return $this->hand;
    }

    public function getCards() {
        return $this->hand;
    }
}
