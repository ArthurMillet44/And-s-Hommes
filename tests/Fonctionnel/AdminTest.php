<?php

namespace App\Tests\Fonctionnel;

use App\Entity\CodePromo;
use App\Entity\Produit;
use App\Repository\CodePromoRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AdminTest extends WebTestCase
{
    private $entityManager;
    //Test qui montre que si on est pas connecter on ce fais rediriger lorsque que l'on tente d'accèder à la route /admin
    public function testVisitorRedirect(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }
    //Test qui montre que si on est connecter avec un role USER on reçoit une erreur 403 lorsque que l'on tente d'accèder à la route /admin
    public function testUserAccessDenied(): void
    {
        $client = static::createClient();

        $container = static::getContainer();
        $this->userRepository = $container->get(UserRepository::class);
        $tabUser = $this->userRepository->findBy(["email"=>"john.doe@gmail.com"]);
        $user= $tabUser[0];
        $client->loginUser($user);

        $client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

    }
    //Test qui montre que si on est connecter avec un role ADMIN on reçoit une reponse 200 lorsque que l'on tente d'accèder à la route /admin
    public function testAdminValid(): void
    {

        $client = static::createClient();

        $container = static::getContainer();
        $this->userRepository = $container->get(UserRepository::class);
        $tabUser = $this->userRepository->findBy(["email"=>"sae.andshommes@gmail.com"]);
        $user= $tabUser[0];
        $client->loginUser($user);

        $client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();


    }

    //Test pour verifier que l'admin peut supprimer un produit
    public function testDeleteProduit(): void{
        $client = static::createClient();
        //recupération du compte admin et connection pour pouvoir accéder à la page admin
        $container = static::getContainer();
        $this->userRepository = $container->get(UserRepository::class);
        $tabUser = $this->userRepository->findBy(["email"=>"sae.andshommes@gmail.com"]);
        $user= $tabUser[0];
        $client->loginUser($user);
        //Création d'un produit
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();
        $this->produitRepository = $container->get(ProduitRepository::class);
        $produit = Produit::factory("Test Delete",1.0,1,"test delete","test","test","test.jpg");
        $this->entityManager->persist($produit);
        $this->entityManager->flush();
        $id = $produit->getId();
        $verifProduit1 = $this->produitRepository->find($id);
        //Test que la requete supprime bien le produit
        $client->request('GET', "/admin/deleteProduit/$id");
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $verifProduit2 = $this->produitRepository->find($id);
        $this->assertNotEquals($verifProduit1,$verifProduit2);
    }
    //Test pour verifier que l'admin peut supprimer un code promo
    public function testDeleteCodePromo(): void{
        $client = static::createClient();
        //recupération du compte admin et connection pour pouvoir accéder à la page admin
        $container = static::getContainer();
        $this->userRepository = $container->get(UserRepository::class);
        $tabUser = $this->userRepository->findBy(["email"=>"sae.andshommes@gmail.com"]);
        $user= $tabUser[0];
        $client->loginUser($user);
        //Création d'un code promo
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();
        $this->code_promoRepository = $container->get(CodePromoRepository::class);
        $code_promo = CodePromo::factory(50,10,"TEST50");
        $this->entityManager->persist($code_promo);
        $this->entityManager->flush();
        $id = $code_promo->getId();
        $verifProduit1 = $this->code_promoRepository->find($id);
        //Test que la requete supprime bien le code promo
        $client->request('GET', "/admin/deleteCode/$id");
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $verifProduit2 = $this->code_promoRepository->find($id);
        $this->assertNotEquals($verifProduit1,$verifProduit2);
    }
}
