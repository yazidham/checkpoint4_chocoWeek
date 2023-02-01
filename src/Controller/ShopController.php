<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('shop/index.html.twig', [
            'products' => $productRepository->findBy([], ['price' => 'ASC']),
        ]);
    }

    #[Route('/shop/{productId}', name: 'app_buy_product')]
    public function buyProduct(int $productId, ProductRepository $productRepository, EntityManagerInterface $manager): RedirectResponse
    {
        $product = $productRepository->findOneBy(['id' => $productId]);
        $productPrice = $product->getPrice();
        $productQuantity = $product->getQuantity();

        /** @var \App\Entity\User */
        $user = $this->getUser();
        $user->setNumberOfCoins($user->getNumberOfCoins() - $productPrice);
        $user->setNumberOfGoldenTickets($user->getNumberOfGoldenTickets() + $productQuantity);
        $manager->persist($user);
        $manager->flush();

        $this->addFlash('success', 'Produit acheté avec succès');
        return $this->redirectToRoute('app_shop');
    }
}