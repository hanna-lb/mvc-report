<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home(): Response
    {
        $number = random_int(0, 100);

        return $this->render('home.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/about")
     */
    public function about(): Response
    {
        $number = random_int(0, 100);

        return $this->render('about.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/report")
     */
    public function report(): Response
    {
        $number = random_int(0, 100);

        return $this->render('report.html.twig', [
            'number' => $number,
        ]);
    }
}
