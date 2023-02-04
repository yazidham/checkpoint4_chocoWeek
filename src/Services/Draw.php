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

    public function getNumberOfDrawableUsers(): int
    {
        $drawableUsers = $this->userRepository->findOneRandomDrawableUser();
        return count($drawableUsers);
    }

    public function pickRandomLooser(): User|null
    {
        $drawableUsers = $this->userRepository->findOneRandomDrawableUser();
        if (empty($drawableUsers)) {
            return null;

        }

        shuffle($drawableUsers);
        $looser = $drawableUsers[0];
        $this->updateLooserStats($looser);

        array_shift($drawableUsers);
        $this->updateWinnersStats($drawableUsers);

        $this->resetPlayers();

        return $looser;
    }

    public function updateLooserStats(User $looser): void
    {
        $NumberOfParticipatingUsers = count($this->userRepository->findParticipatingUsers());
        $looser->setNumberOfDraw($looser->getNumberOfDraw() + 1);
        $looser->setNumberOfChocoPaid($looser->getNumberOfChocoPaid() + $NumberOfParticipatingUsers - 1);
    }

    public function updateWinnersStats(array $participants): void
    {
        $goldenParticipants = $this->userRepository->findGoldenParticipants();
        $winners = array_merge($goldenParticipants, $participants);
        foreach ($winners as $winner) {
            $winner->setNumberOfChocoeaten($winner->getNumberOfChocoeaten() + 1);
        }
    }

    public function resetPlayers(): void
    {
        $participatingUsers = $this->userRepository->findParticipatingUsers();

        foreach ($participatingUsers as $participatingUser) {
            $participatingUser->setIsParticipating(false);
            if ($participatingUser->isIsGolden()) {
                $participatingUser->setNumberOfGoldenTickets($participatingUser->getNumberOfGoldenTickets() - 1);
            }
            $participatingUser->setNumberOfParticipation($participatingUser->getNumberOfParticipation() + 1);
            $participatingUser->setIsGolden(false);
            $this->manager->persist($participatingUser);
        }

        $this->manager->flush();
    }
}
