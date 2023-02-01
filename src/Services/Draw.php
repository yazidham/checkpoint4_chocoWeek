<?php

namespace App\Services;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class Draw
{
    private UserRepository $userRepository;
    private EntityManagerInterface $manager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $this->userRepository = $userRepository;
        $this->manager = $manager;
    }

    public function addUserToDraw(int $userId): void
    {
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        $user->setIsParticipating(true);
        if (isset($_POST['golden'])) {
            $user->setNumberOfGoldenTickets($user->getNumberOfGoldenTickets() - 1);
            $user->setIsGolden(true);
        }
        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function removeUserFromTheDraw(int $userId): void
    {
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        $user->setIsParticipating(false);
        if ($user->isIsGolden()) {
            $user->setNumberOfGoldenTickets($user->getNumberOfGoldenTickets() + 1);
            $user->setIsGolden(false);
        }
        $this->manager->persist($user);
        $this->manager->flush();
    }
}
