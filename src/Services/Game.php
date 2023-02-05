<?php

namespace App\Services;

use App\Entity\Ranking;
use App\Entity\Riddle;
use App\Entity\User;
use App\Repository\RankingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class Game
{
    private UserRepository $userRepository;
    private RankingRepository $rankingRepository;
    private EntityManagerInterface $manager;

    /**
     * @param UserRepository $userRepository
     * @param RankingRepository $rankingRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(UserRepository $userRepository, RankingRepository $rankingRepository, EntityManagerInterface $manager)
    {
        $this->userRepository = $userRepository;
        $this->rankingRepository = $rankingRepository;
        $this->manager = $manager;
    }

    public function getOrCreatePlayer(int $userId, Riddle $riddle): ?Ranking
    {
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        $rank = $this->rankingRepository->findOneBy(['user' => $user->getId(), 'riddle' => $riddle->getId()]);
        if (!$rank) {
            $rank = new Ranking();
            $rank->setUser($user);
            $rank->setRiddle($riddle);
            $rank->setNumberOfTries(0);
            $rank->setHasGuessed(0);
        }

        return $rank;
    }

    public function answerManager(Ranking $rank,Riddle $riddle): array
    {
        $rank->setNumberOfTries($rank->getNumberOfTries() + 1);
        if (strtoupper($_POST['guess']) === $riddle->getAnswer()) {
            $rank->setHasGuessed(1);
            return ["success" , "Felicitation tu as deviné"];
        } else {
            return ["danger", "Mauvaise réponse"];
        }
    }
}
