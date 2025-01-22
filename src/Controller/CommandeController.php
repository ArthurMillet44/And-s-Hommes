<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\User;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends BaseController
{
    //Méthode qui récupère le user connecté et renvoie sont historique de commande à la vue
    #[Route('/commande', name: 'app_commande')]
    public function index(CommandeRepository $repository): Response
    {
        $this->addGlobalVariables();
        $user = $this->getUser();
        $listeCommande = $repository->findby(['user' => $user]);
        return $this->render('commande/index.html.twig', [
            'listeCommande' => $listeCommande,
        ]);
    }

    //Controlleur qui permet d'ajouter une commande.

    //fonction permettant d'ajouter la commande dans la table commande et supprime également le panier de l'utilisateur
    #[Route('/commande/ajoutCommande', name: 'ajout_commande')]
    public function ajoutCommande(CommandeRepository $repository_commande){
        if (!isset($_POST["input_code_promo"])){
            $_POST["input_code_promo"]="";
        }
        $repository_commande->ajouterCommandeEtSupprimerPanier($this->getUser()->getId(),$_POST["input_code_promo"]);
        return $this->redirectToRoute('home.index');
    }


}
