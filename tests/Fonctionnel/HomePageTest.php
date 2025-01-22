<?php

namespace App\Tests\Fonctionnel;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageTest extends WebTestCase
{
    //Test pour vérifier qu'il y a bien un bouton pour chaque catégorie
    public function testVerifBouton(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $button = $crawler->filter(".BoutonDECOUVRIR");
        $this->assertEquals(4,count($button));

    }
}
