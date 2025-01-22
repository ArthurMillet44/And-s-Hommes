<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use App\Entity\Panier;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{

    //Controlleur permettant d'ajouter au panier de l'utilisateur.
    #[Route('/categorie/addPanier/{id}', name: 'add_to_panier')]
    public function addPanier(PanierRepository $panierRepository, int $id): Response
    {
        //On regarde qui est notre utlisateur
        $user = $this->getUser();

        //On récupère toutes les lignes de la table panier (qui représente les produits) de l'utilisateur.
        $panierID = $panierRepository->findBy(["user" => $user]);

        //Boucle sur tous les produits du panier de l'utilisateur
        foreach ($panierID as $ligne) {
            //Si le produit qu'on voit est égal à l'id du produit que l'utilistateur veut mettre au panier
            if ($ligne->getProduit()->getId() == $id) {
                $panierRepository->AugmenterQuantite($ligne->getId());
                return new Response();
            }

        }
        //Si le produit ne se situe finalement pas dans la base, alors on créer un nouveau produit dans un panier grâce à une factory.
        //(c'est à dire une nouvelle ligne dans la table panier.)
        $panierRepository->AjouterPanier($id,$user->getId());
        return new Response();
    }
}
