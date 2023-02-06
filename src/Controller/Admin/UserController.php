<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
#[Route('admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{

    #[Route('/show', name: 'show')]
    public function showUsers(UserRepository $userRepository, EntityManagerInterface $manager): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $userRepository->findOneBy(['id' => $_POST['userId']]);
            $user->setNumberOfCoins($user->getNumberOfCoins() + $_POST['chocoCoins']);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', ''. $_POST['chocoCoins'] . ' chocoCoins à ' . $user->getUsername());
            $this->redirectToRoute('admin_user_show');
        }

        return $this->render('admin/showUsers.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}