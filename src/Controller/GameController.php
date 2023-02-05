<?php

namespace App\Controller;

use App\Entity\Riddle;
use App\Form\RiddleType;
use App\Repository\RankingRepository;
use App\Repository\RiddleRepository;
use App\Services\Game;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
#[Route('/game', name: 'app_')]
class GameController extends AbstractController
{
    #[Route('/', name: 'game')]
    public function index(RiddleRepository $riddleRepository, RankingRepository $rankingRepository): Response
    {
        $riddlesSolvedId = [];
        $riddlesSolved = $rankingRepository->findBy(['user' => $this->getUser(), 'hasGuessed' => true]);

        foreach ($riddlesSolved as $riddleSolved) {
            $riddlesSolvedId[] = $riddleSolved->getRiddle()->getId();
        }

        return $this->render('game/index.html.twig', [
            'riddles' => $riddleRepository->findby([], ['id' => 'DESC']),
            'riddlesSolved' => $riddlesSolvedId,
        ]);
    }

    #[Route('/new', name: 'game_new')]
    public function newRiddle(EntityManagerInterface $manager, Request $request): Response
    {
        $riddle = new Riddle();
        $form = $this->createForm(RiddleType::class, $riddle);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $answer = strtoupper($form['answer']->getData());
            $riddle->setAnswer($answer);
            $riddle->setAuthor($this->getUser());
            $manager->persist($riddle);
            $manager->flush();

            $this->addFlash('success', 'ChocoGuess ajouté avec succès');
            return $this->redirectToRoute('app_game');
        }

        return $this->render('game/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'game_show', methods: ['GET', 'POST'])]
    public function showRiddle(Riddle                 $riddle,
                               RankingRepository      $rankingRepository,
                               EntityManagerInterface $manager,
                               Game                   $game,
    ): Response
    {

        /** @var \App\Entity\User */
        $user = $this->getUser();
        $message = [];

        $rank = $game->getOrCreatePlayer($user->getId(), $riddle);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $game->answerManager($rank, $riddle);
        }

        $manager->persist($rank);
        $manager->flush();

        $currentUserRank = $rankingRepository->findOneBy(['user' => $user->getId(), 'riddle' => $riddle->getId()]);
        $playersRanking = $rankingRepository->findBy(['hasGuessed' => true, 'riddle' => $riddle], ['numberOfTries' => 'ASC']);


        return $this->render('game/showGuess.html.twig', [
            'riddle' => $riddle,
            'message' => $message,
            'numberOfTries' => $currentUserRank->getNumberOfTries(),
            'hasGuessed' => $currentUserRank->isHasGuessed(),
            'playersRanking' => $playersRanking
        ]);
    }
}
