<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{
    #[Route('/show', name: 'show')]
    public function showUsers(UserRepository $userRepository, EntityManagerInterface $manager): Response
    {
        if (isset($_GET['chocoCoins']) && $_GET['chocoCoins'] !== "") {
            $user = $userRepository->findOneBy(['id' => $_GET['userId']]);
            $user->setNumberOfCoins($user->getNumberOfCoins() + $_GET['chocoCoins']);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', ''. $_GET['chocoCoins'] . ' chocoCoins à ' . $user->getUsername());
            $this->redirectToRoute('admin_user_show');
        }
        return $this->render('admin/showUsers.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

}