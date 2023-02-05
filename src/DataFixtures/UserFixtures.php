<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $admin = new User();
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin1212'));
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNumberOfCoins(40);
        $admin->setNumberOfGoldenTickets(10);
        $admin->setNumberOfDraw(0);
        $admin->setNumberOfChocoPaid(0);
        $admin->setNumberOfChocoEaten(0);
        $admin->SetIsParticipating(0);
        $admin->SetIsGolden(0);
        $manager->persist($admin);

        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));
            $user->setUsername('user' . $i);
            $user->setNumberOfCoins($faker->numberBetween(0, 20));
            $user->setNumberOfGoldenTickets($faker->numberBetween(0, 3));
            $user->setNumberOfDraw($faker->numberBetween(0, 5));
            $user->setNumberOfChocoPaid($faker->numberBetween(0, 10));
            $user->setNumberOfChocoEaten($faker->numberBetween(0, 7));
            $user->SetIsParticipating($faker->boolean());
            $user->SetIsGolden($faker->boolean());
            $manager->persist($user);
        }

        $manager->flush();
    }
}
