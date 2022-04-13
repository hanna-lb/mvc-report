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
            'title' => 'Kortlek',
            'deck' => $deck->getDeck(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }
}
