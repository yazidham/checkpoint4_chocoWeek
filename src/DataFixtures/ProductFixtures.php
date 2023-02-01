<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $product = new Product();
         $product->setName("1 ticket d'or");
         $product->setPrice(5);
         $manager->persist($product);

        $product = new Product();
        $product->setName("5 ticket d'or");
        $product->setPrice(20);
        $manager->persist($product);

        $product = new Product();
        $product->setName("10 ticket d'or");
        $product->setPrice(40);
        $manager->persist($product);

        $manager->flush();
    }
}
