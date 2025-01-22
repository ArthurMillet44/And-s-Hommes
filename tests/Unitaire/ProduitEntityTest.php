<?php

namespace App\Tests\Unitaire;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProduitEntityTest extends KernelTestCase
{
    public function getEntity(): Produit{
        return Produit::factory("test",10.5,5,"test produit","Test","SousTest","test.png");

    }
    //Test pour verifier que le Produit est bien créer
    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $produit = $this->getEntity();
        $errors = $container->get('validator')->validate($produit);
        $this->assertCount(0,$errors);
    }

}
