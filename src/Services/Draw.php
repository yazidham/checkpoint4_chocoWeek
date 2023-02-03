<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use function PHPUnit\Framework\isEmpty;

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

    public function getNumberOfDrawableeUsers(): int
    {
        $drawableUsers = $this->userRepository->findOneRandomDrawableUser();
        return count($drawableUsers);
    }

    public function pickRandomLooser(): User
    {
        $drawableUsers = $this->userRepository->findOneRandomDrawableUser();
        $numberOfParticipatingUsers = count($drawableUsers);
        $randomIndex = rand(0, $numberOfParticipatingUsers);
        return $drawableUsers[$randomIndex];
    }

    public function ResetPlayers(): void
    {
        $participatingUsers = $this->userRepository->findParticipatingUsers();

        foreach ($participatingUsers as $participatingUser) {
            $participatingUser->setIsParticipating(false);
            if ($participatingUser->isIsGolden()) {
                $participatingUser->setNumberOfGoldenTickets($participatingUser->getNumberOfGoldenTickets() - 1);
            }
            $participatingUser->setIsGolden(false);
            $this->manager->persist($participatingUser);
        }

        $this->manager->flush();
    }
}
