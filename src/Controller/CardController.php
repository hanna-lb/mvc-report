<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function shuffleDeck(SessionInterface $session): Response
    {
        $session->clear();
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        $data = [
            'title' => 'Blandad kortlek',
            'deck' => $deck->getDeck(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="card-draw")
     */
    public function draw(SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? new \App\Card\Deck();
        $deck->shuffle();

        $drawnCards = $deck->drawCard(1);
        $cardsLeft = $deck->countDeck();

        $hand = $session->get("hand") ?? [];
        $hand = array_merge($hand, $drawnCards);
        
        $session->set("deck", $deck);
        $session->set("hand", $hand);

        $data = [
            'title' => "Dra kort",
            'drawnCards' => $drawnCards,
            'hand' => $hand,
            'count' => $cardsLeft,
            'number' => '1'
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw/:{number}", name="card-draw-number", methods={"GET","HEAD"})
     */
    public function drawNumber(SessionInterface $session, $number): Response 
    {
        $deck = $session->get("deck") ?? new \App\Card\Deck();
        $deck->shuffle();

        $drawnCards = $deck->drawCard($number);
        $cardsLeft = $deck->countDeck();

        $hand = $session->get("hand") ?? [];
        $hand = array_merge($hand, $drawnCards);
        
        $session->set("deck", $deck);
        $session->set("hand", $hand);

        $data = [
            'title' => "Dra kort",
            'drawnCards' => $drawnCards,
            'hand' => $hand,
            'count' => $cardsLeft,
            'number' => $number
        ];

        return $this->render('card/draw-number.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw/:{number}", name="card-draw-process", methods={"POST"})
     */
    public function drawNumberProcess(Request $request, SessionInterface $session, $number): Response 
    {
        $draw = $request->request->get('draw');
        $reset = $request->request->get('reset');

        if ($reset) {
            $session->clear();
        } elseif ($draw) {
            $number = $request->request->get('drawnumber');
        }

        return $this->redirectToRoute('card-draw-number', ['number' => $number]);
    }

    /**
     * @Route("/card/deck/deal/:{players}/:{cards}", name="card-deal", methods={"GET","HEAD"})
     */
    public function deal($players, $cards): Response 
    {
        $deck = new \App\Card\Deck();
        $deck->shuffle();

        $playerHands = [];
        
        for ($i = 0; $i < $players; $i++) {
            $playerHands[] = $deck->drawCard($cards);
        }

        $cardsLeft = $deck->countDeck();

        $data = [
            'title' => "Dela ut kort till spelare",
            'playerHands' => $playerHands,
            'players' => $players,
            'number' => $cards,
            'count' => $cardsLeft,
        ];

        return $this->render('card/deal.html.twig', $data);
    }

    /**
     * @Route("/card/deck/deal/:{players}/:{cards}", name="card-deal-process", methods={"POST"})
     */
    public function dealProcess(Request $request, $players, $cards): Response 
    {
        $players = $request->request->get('players');
        $cards = $request->request->get('cards');

        return $this->redirectToRoute('card-deal', ['players' => $players, 'cards' => $cards]);
    }
}
