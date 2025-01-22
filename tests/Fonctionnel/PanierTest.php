<?php

namespace App\Tests\Fonctionnel;

use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PanierTest extends WebTestCase
{
    public function testAjoutPanier(): void
    {
        // création d'un client et d'un container pour pouvoir accéder au repository
        $client = static::createClient();
        $container = static::getContainer();
        // récupération des repository
        $this->userRepository = $container->get(UserRepository::class);
        $this->produit_repository = $container->get(ProduitRepository::class);
        $this->panier_repository = $container->get(PanierRepository::class);
        //tableau contenant le user actuel pour notre test (user à insérer manuellement : insert into user (name,surname,date_of_birth,email,roles,password,is_verified) values ('Doe','John','2000-01-01','john.admin@gmail.com','["ROLE_ADMIN"]','$2y$04$N0eAU9wB8c5kOXkyMi0CouGf1dzutUhh655FxGHAj1/vhyvTgk/x6',true);)
        $tabUser = $this->userRepository->findBy(["email"=>"sae.andshommes@gmail.com"]);
        $user= $tabUser[0];
        // connexion avec idendifiants user
        $client->loginUser($user);
        //requete appelant notre route pour ajouter au panier
        $client->request('GET', '/categorie/addPanier/4');
        // récupération du panier normalement crée
        $produit = $this->produit_repository->find(4);
        $result = $this->panier_repository->findBy(["produit" => $produit]);

        // vérification que le panier a bien été crée
        $this->assertNotEmpty($result);
    }



    public function testDeleteProduitPanier():void{
        // création d'un client et d'un container pour pouvoir accéder au repository
        $client = static::createClient();
        $container = static::getContainer();
        // récupération des repository
        $this->userRepository = $container->get(UserRepository::class);
        $this->produit_repository = $container->get(ProduitRepository::class);
        $this->panier_repository = $container->get(PanierRepository::class);
        //tableau contenant le user actuel pour notre test (user à insérer manuellement : insert into user (name,surname,date_of_birth,email,roles,password,is_verified) values ('Doe','John','2000-01-01','john.admin@gmail.com','["ROLE_ADMIN"]','$2y$04$N0eAU9wB8c5kOXkyMi0CouGf1dzutUhh655FxGHAj1/vhyvTgk/x6',true);)
        $tabUser = $this->userRepository->findBy(["email"=>"sae.andshommes@gmail.com"]);
        $user= $tabUser[0];
        // connexion avec idendifiants user
        $client->loginUser($user);
        //requete appelant notre route pour supprimer au panier
        $client->request('GET', '/panier/supprimer/4');
        // récupération du panier normalement supprimé
        $produit = $this->produit_repository->find(4);
        $result = $this->panier_repository->findBy(["produit" => $produit]);

        // vérification que le panier a bien été supprimé
        $this->assertEmpty($result);
    }

    public function testAugmentationQuantite():void{
        // création d'un client et d'un container pour pouvoir accéder au repository
        $client = static::createClient();
        $container = static::getContainer();

        // récupération des repository
        $this->userRepository = $container->get(UserRepository::class);
        $this->produit_repository = $container->get(ProduitRepository::class);
        $this->panier_repository = $container->get(PanierRepository::class);
        //tableau contenant le user actuel pour notre test (user à insérer manuellement : insert into user (name,surname,date_of_birth,email,roles,password,is_verified) values ('Doe','John','2000-01-01','john.admin@gmail.com','["ROLE_ADMIN"]','$2y$04$N0eAU9wB8c5kOXkyMi0CouGf1dzutUhh655FxGHAj1/vhyvTgk/x6',true);)
        $tabUser = $this->userRepository->findBy(["email"=>"sae.andshommes@gmail.com"]);
        $user= $tabUser[0];
        // connexion avec idendifiants user
        $client->loginUser($user);
        //requete appelant notre route pour ajouter au panier
        $client->request('GET', '/categorie/addPanier/4');
        //récupération de la quantité avant augmentation
        $produit = $this->produit_repository->find(4);
        $produitavant = $this->panier_repository->findBy(["produit" => $produit]);
        $quantite_avant = $produitavant[0]->getQuantite();
        //requete appelant notre route pour augmenter quantité du produit commandé
        $client->request('GET', '/panier/augmenter/4');
        //récupération de la quantité après augmentation
        $produit = $this->produit_repository->find(4);
        $produitapres = $this->panier_repository->findBy(["produit" => $produit]);
        $quantite_apres = $produitapres[0]->getQuantite();

        //test pour vérifier si la quantité avant est supérieur de 1 à la quantité après

        $this->assertEquals($quantite_avant+1 , $quantite_apres);
    }



}
