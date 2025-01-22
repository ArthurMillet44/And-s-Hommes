<?php

namespace App\Tests\Unitaire;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PanierEntityTest extends KernelTestCase
{

    //Test pour verifier que le Panier est bien créer
    public function testEntityPanier(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $userRepository = $container->get(UserRepository::class);
        $produitRepository = $container->get(ProduitRepository::class);
        $user = $userRepository->findBy(["email"=>"john.doe@gmail.com"]) ;
        $produit = $produitRepository->find(1);
        $panier = Panier::factory($user[0],$produit,1);
        $errors = $container->get('validator')->validate($panier);
        $this->assertCount(0,$errors);

    }
}
