<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/user', name : 'admin_user_')]
class UserController extends AbstractController
{
    #[Route('/show', name : 'show')]
    public function showUsers(UserRepository $userRepository): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
        return $this->render('admin/showUsers.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

}