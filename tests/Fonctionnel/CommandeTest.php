<?php

namespace App\Tests\Fonctionnel;

use App\Entity\Panier;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CommandeTest extends WebTestCase
{
    //Test payer pour vérifier la redirection et l'ajout dans panier
    public function testPayer(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        $userRepository = $container->get(UserRepository::class);
        $produitRepository = $container->get(ProduitRepository::class);
        $user = $userRepository->findBy(["email"=>"john.doe@gmail.com"]) ;
        $produit = $produitRepository->find(1);
        $panier = Panier::factory($user[0],$produit,1);
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();
        $this->entityManager->persist($panier);
        $this->entityManager->flush();
        $client->loginUser($user[0]);

        $crawler = $client->request('GET', "/panier");
        $submitButton = $crawler->selectButton("Payer");
        $form = $submitButton->form();
        $form['livraison'] = "Colissimo";
        $form['moyen_paiement'] = "Carte_Bancaire";

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $commandeRepository = $container->get(CommandeRepository::class);
        $tabCommande = $commandeRepository->findBy(["user"=>$user[0]]);
        $this->assertNotEmpty($tabCommande);


    }
}
