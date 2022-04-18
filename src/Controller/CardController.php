<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use App\Card\Deck;

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
        $deck = new Deck();

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
        $deck = new Deck();
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
        $deck = $session->get("deck") ?? new Deck();
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
        $deck = $session->get("deck") ?? new Deck();
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
    public function deal(SessionInterface $session, $players, $cards): Response 
    {
        $deck = $session->get("deck") ?? new Deck();
        $playerObjects = $session->get("playerObjects") ?? [];

        $deck->shuffle();
        
        $playerHands = [];

        for ($i = 0; $i < $players; $i++) {
            $drawnCards = $deck->drawCard($cards);
            
            if (array_key_exists($i, $playerObjects)) {
                $playerObjects[$i]->addCards($drawnCards);
            } else {
                $playerObjects[] = new \App\Card\Player($drawnCards);
            }

            $playerHands[] = $playerObjects[$i]->getHand();
        }

        $cardsLeft = $deck->countDeck();

        $session->set("deck", $deck);
        $session->set("playerObjects", $playerObjects);

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
    public function dealProcess(Request $request, SessionInterface $session, $players, $cards): Response 
    {
        $cards = $request->request->get('cards');

        $reset = $request->request->get('reset');

        if ($reset) {
            $players = $request->request->get('players');
            $session->clear();
        }

        return $this->redirectToRoute('card-deal', ['players' => $players, 'cards' => $cards]);
    }

    /**
     * @Route("/card/deck2", name="card-deck2")
     */
    public function deck2(): Response
    {
        $deck = new \App\Card\DeckWithJoker();

        $data = [
            'title' => 'Kortlek med jokrar',
            'deck' => $deck->getDeck(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }
}
