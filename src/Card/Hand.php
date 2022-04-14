<?php

namespace App\Card;

use App\Card\Card;

class Hand
{
    protected $hand = [];

    public function __construct($cards)
    {
        $this->hand = $cards;
    }

    public function addCards($cards)
    {
        $this->hand[] = $cards;

        return $this->hand;
    }

    public function getCards() {
        return $this->hand;
    }
}
