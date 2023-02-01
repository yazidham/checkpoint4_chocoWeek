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
         $product->setName("Golden Ticket");
         $product->setPrice(5);
        $product->setQuantity(1);
         $manager->persist($product);

        $product = new Product();
        $product->setName("Golden Tickets");
        $product->setPrice(20);
        $product->setQuantity(5);
        $manager->persist($product);

        $product = new Product();
        $product->setName("Golden Tickets");
        $product->setQuantity(10);
        $product->setPrice(40);
        $manager->persist($product);

        $manager->flush();
    }
}
