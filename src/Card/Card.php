<?php

namespace App\Card;

class Card
{
    public $colour;
    public $value;
    protected $name;

    public function __construct($colour, $value)
    {
        $this->colour = $colour;
        $this->value = $value;
    }

    public function getAsString(): string
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
            default:
                $this->name .= $this->value;
        }
        
        return "[{$this->name}]";
    }
}
