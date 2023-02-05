<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [

        ]);
    }

//    #[Route('/game/show/{id}', name: 'app_game_show', methods: ['GET'])]
//    public function showGuess(): Response
//    {
//        return $this->render('game/showGuess.html.twig', [
//
//        ]);
//    }

    #[Route('/game/show', name: 'app_game_show')]
    public function showGuess(): Response
    {
        return $this->render('game/showGuess.html.twig', [

        ]);
    }
}
