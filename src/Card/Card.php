<?php

namespace App\Card;

class Card
{
    protected string $colour;
    protected string $value;
    protected string $name;

    public function __construct($colour, $value)
    {
        $this->colour = $colour;
        $this->value = $value;
        $this->generateName();
    }

    public function generateName(): void
    {
        switch ($this->colour){
            case "spades":
                $this->name = "Spader ";
                break;
            case "hearts":
                $this->name = "Hjärter ";
                break;
            case "clubs":
                $this->name = "Klöver ";
                break;
            case "diamonds":
                $this->name = "Ruter ";
                break;
            default:
                $this->name = "";
        }
        
        switch ($this->value){
            case "E":
                $this->name .= "ess";
                break;
            case "D":
                $this->name .= "dam";
                break;
            case "Kn":
                $this->name .= "knekt";
                break;
            case "K":
                $this->name .= "kung";
                break;
            case "Joker":
                $this->name = "Joker";
            default:
                $this->name .= $this->value;
        }
    }

    public function getColour(): string
    {
        return $this->colour;   
    }

    public function getValue(): string
    {
        return $this->value;   
    }

    public function getName(): string
    {
        return $this->name;   
    }

    public function toArray(): array
    {
        $card = [
            "colour" => $this->colour,
            "value" => $this->value,
            "name" => $this->name
        ];

        return $card;
    }
}
