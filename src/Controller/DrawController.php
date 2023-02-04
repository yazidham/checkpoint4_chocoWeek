<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Services\Draw;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DrawController extends AbstractController
{
    #[Route('/draw', name: 'app_draw')]
    public function index(UserRepository $userRepository, Request $request, Draw $draw): Response
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

        //handle ajax request
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'content' => $this->renderView('_includes/_participant_list.html.twig', [
                    'participants' => $userRepository->findBy(['isParticipating' => true]),
                ])
            ]);
        }

        return $this->render('draw/index.html.twig', [
            'numberOfDrawableUsers' => $draw->getNumberOfDrawableeUsers(),
            'participants' => $userRepository->findBy(['isParticipating' => true]),
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
