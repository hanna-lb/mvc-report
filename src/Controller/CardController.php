<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card-home")
     */
    public function card(): Response
    {
        return $this->render('card/home.html.twig');
    }

    /**
     * @Route("/card/deck", name="card-deck")
     */
    public function deck(): Response
    {
        $deck = new \App\Card\Deck();

        $data = [
            'title' => 'Sorterad kortlek',
            'deck' => $deck->getDeck(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="card-deck-shuffle")
     */
    public function shuffleDeck(): Response
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        $data = [
            'title' => 'Blandad kortlek',
            'deck' => $deck->getDeck(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="card-deck-draw")
     */
    public function draw(): Response
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();
        $drawnCards = $deck->drawCard(1);
        $cardsLeft = $deck->countDeck();

        $data = [
            'title' => 'Du drar 1 kort',
            'deck' => $drawnCards,
            'count' => $cardsLeft
        ];

        return $this->render('card/draw.html.twig', $data);
    }
}
