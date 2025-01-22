<?php

namespace App\Tests\Unitaire;

use App\Entity\CodePromo;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CodePromoEntityTest extends KernelTestCase
{
    public function getEntity(): CodePromo{
        return CodePromo::factory(50,10,"TEST50");

    }
    public function testSomething(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $codePromo = $this->getEntity();
        $errors = $container->get('validator')->validate($codePromo);
        $this->assertCount(0,$errors);
    }
}
