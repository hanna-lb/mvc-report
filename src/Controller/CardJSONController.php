<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Card\Deck;

class CardJSONController extends AbstractController
{
    /**
     * @Route("/card/api/deck", name="card-api-deck", methods={"GET"})
     */
    public function deckJSON(): Response
    {
        $deck = new Deck();

        $data = [
            'cards' => $deck->toArray()
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/card/api/deal/:{players}/:{cards}", name="card-api-deal", methods={"GET"})
     */
    public function dealJSON($players, $cards): Response 
    {
        $deck = new Deck();
        $deck->shuffle();
        $playerObjects = [];        
        $playerHands = [];

        for ($i = 0; $i < $players; $i++) {
            $drawnCards = $deck->drawCard($cards);
            $playerObjects[] = new \App\Card\Player($drawnCards);
            $playerHands[$i]["playerNo"] = $i;
            $playerHands[$i]["cards"] = $playerObjects[$i]->toArray();
        }

        $cardsLeft = $deck->countDeck();

        $data = [
            'noOfPlayers' => $players,
            'numberOfCards' => $cards,
            'cardsLeft' => $cardsLeft,
            'players' => $playerHands,
        ];

        return new JsonResponse($data);        
    }
}
