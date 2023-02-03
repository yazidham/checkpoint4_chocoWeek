<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Services\Draw;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DrawController extends AbstractController
{
    #[Route('/draw', name: 'app_draw')]
    public function index(UserRepository $userRepository, EntityManagerInterface $manager, Draw $draw): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /** @var \App\Entity\User */
            $user = $this->getUser();

            if ($user->IsIsParticipating()) {
                $draw->removeUserFromTheDraw($user->getId());
                $this->addFlash('warning', 'Vous avez été désinscrit avec succès');
            } else {
                $draw->addUserToDraw($user->getId());
                $this->addFlash('success', 'Vous avez été inscrit avec succès');
            }

            return $this->redirectToRoute('app_draw');
        }

        return $this->render('draw/index.html.twig', [
            'participants' => $userRepository->findBy(['isParticipating' => true]),
            'numberOfDrawableUsers' => $draw->getNumberOfDrawableeUsers()
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/draw/start', name: 'app_draw-start')]
    public function startDraw(Draw $draw): Response
    {
        $looser = $draw->pickRandomLooser();
        $draw->ResetPlayers();

        return $this->render('draw/startDraw.html.twig', [
            'looser' => $looser,
        ]);
    }
}
