<?php

namespace App\Card;

use App\Card\Card;

class Player
{
    private $hand = [];

    public function __construct(array $cards)
    {
        $this->hand = $cards;
    }

    public function addCards(array $cards): void
    {
        $this->hand = array_merge($this->hand, $cards);
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function toArray(): array
    {
        $array = [];

        foreach ($this->hand as $card) {
            $array[] = $card->toArray();
        }

        return $array;
    }
}
