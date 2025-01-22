<?php

namespace App\Controller;

use App\Entity\CodePromo;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use App\Repository\CodePromoRepository;
use App\Repository\MessageRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Environment;


class AdminController extends BaseController
{

    public function __construct(private ManagerRegistry $doctrine,PanierRepository $panierRepository, Environment $environment) {
        parent::__construct($panierRepository, $environment);

    }


    //Pour + de clarté, la fonction pricipale sencé être index() a été renommé affichagePageAdmin().
    //En effet, la page de base de admin est en fait un affichage de tous les produits,users et codePromo

    #[Route('/admin', name: 'app_admin_controlleur')]

    public function affichagePageAdmin(ProduitRepository $repository, UserRepository $repository_user,  CodePromoRepository $repository_code_promo, MessageRepository $repository_message) : Response{
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->addGlobalVariables();
        //On va chercher tous les produits les users ainsi que les codes promos dans la base de données.

        $produits = $repository->findAll();
        $users = $repository_user->findAll();
        $codes_promo = $repository_code_promo->findAll();
        $messages = $repository_message->findAll();

        //La valeur de retour de type réponse prend en paramètre:
        //- une page template
        //- Les variables connue sur toute la page (utilisation de variables PHP grâce à Twig.)
        return $this->render('admin/index.html.twig', [
            'produits' => $produits, // on passe la variable produit à la vue
            'users' => $users,
            'codes_promo' => $codes_promo,
            'messages' => $messages
        ]);
    }



    //Controleur qui renvoit sur la page d'ajout de produit.
    #[Route('/admin/formAjouterProduit', name: 'app_admin_controlleur_form_ajout_produit')]
    public function ajouterProduitForm() : Response{
        $this->addGlobalVariables();
        return $this->render('admin/formAjouterProduit.html.twig');
    }

    //Controlleur qui permet d'ajouter un produit
    #[Route('/admin/AjouterProduit', name: 'app_admin_controlleur_ajout_produit')]
    public function addProduct(EntityManagerInterface $entityManager) : RedirectResponse
    {
        //On va d'abord créer un produit grâce à la factory située dans la classe Produit.

        $produit= Produit::factory($_POST["nom"],$_POST["prix"],$_POST["quantite"],$_POST["description"],$_POST["categories"],$_POST["sous_categories"],$_POST["image"]);

        //Entity manager est une fonctionnalité de Doctrine permettant d'intéragir facilement avec la base de donnée.
        //persist() est utilisé pour update ainsi que insert

        $entityManager->persist($produit);

        //flush() permet de mettre à jour la base de donnée selon les exigences de la fonction précédente.

        $entityManager->flush();
        return $this->redirectToRoute('app_admin_controlleur',[]);
    }

    //Controlleur qui permet de supprimer un produit.
    #[Route('/admin/deleteProduit/{id}', name: 'app_admin_controlleur_delete_produit')]
    public function deleteProduit(int $id ,ProduitRepository $repository) : RedirectResponse{
        $repository->DeleteProduit($id);
        return $this->redirectToRoute('app_admin_controlleur',[]);
    }

    //Controlleur qui amène sur la page de mise à jour du produit.
    #[Route('/admin/updateProduitForm/{id}', name: 'app_admin_controlleur_update_produit_form')]
    public function updateProduitForm(int $id,ProduitRepository $repository ) : Response{
        $this->addGlobalVariables();
        $produit = $repository->find($id);
        return $this->render("admin/formUpdateProduit.html.twig",['produit' => $produit]);
    }

    //Controlleur qui permet de mettre à jour le produit.
    #[Route('/admin/updateProduit/{id}', name: 'app_admin_controlleur_update_produit')]
    public function updateProduit(int $id ,ProduitRepository $repository):RedirectResponse{
        $repository->ModifierProduit($id,$_POST["nom"],$_POST["prix"],$_POST["quantite"],$_POST["description"],$_POST["categories"],$_POST["sous_categories"],$_POST["image"]);
        return $this->redirectToRoute('app_admin_controlleur',[]);

    }

    //Controlleur permetant de supprimer un utilisateur
    #[Route('/admin/deleteUser/{id}', name: 'app_admin_controlleur_delete_user')]
    public function deleteUser(int $id, UserRepository $repository_user) : RedirectResponse{
        $repository_user->DeleteUser($id);
        return $this->redirectToRoute('app_admin_controlleur',[]);

    }



    //Controlleur permetant de se rendre à la page de mise à jour du code_promo.
    #[Route('/admin/updateCodePromo/{id}', name: 'app_admin_controlleur_update_code_form')]
    public function updateCodePromo(int $id,CodePromoRepository $repository) : Response{
        $this->addGlobalVariables();
        $code = $repository->find($id);
        return $this->render("admin/formUpdateCode.html.twig",['code' => $code]);
    }

    //Controlleur qui permet de mettre à jour le code.
    #[Route('/admin/updateCode/{id}', name: 'app_admin_controlleur_update_code')]
    public function updateCode(int $id,ProduitRepository $repository, UserRepository $repository_user,CodePromoRepository $repository_code_promo){
        $repository_code_promo->ModifierCode($id,$_POST["pourcentage"],$_POST["nbr_use"],$_POST["nom_code"]);
        return $this->affichagePageAdmin($repository,$repository_user,$repository_code_promo);
    }

    //Controlleur permettant de se rendre à la page de création un nouveau Code.
    #[Route('/admin/formAjouterCode', name: 'app_admin_controlleur_form_ajout_code')]
    public function ajouterCodeForm() : Response{
        $this->addGlobalVariables();
        return $this->render('admin/formAjouterCode.html.twig');
    }

    //Controlleur permettant de ajouter un nouveau code dans la base.
    #[Route('/admin/ajouterCode', name: 'app_admin_controlleur_ajout_code')]
    public function addCode(EntityManagerInterface $entityManager) : RedirectResponse
    {
        $code= CodePromo::factory($_POST["pourcentage"],$_POST["nbr_use"],$_POST["nom_code"]);
        $entityManager->persist($code);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_controlleur');
    }
    //Controlleur permetant de supprimer un code_promo
    #[Route('/admin/deleteCode/{id}', name: 'app_admin_controlleur_delete_code')]
    public function deleteCode(int $id,CodePromoRepository $repository_code_promo){
        $repository_code_promo->DeleteCode($id);
        return $this->redirectToRoute('app_admin_controlleur');

    }

    #[Route('/admin/deleteMessage/{id}', name: 'app_admin_controlleur_delete_message')]
    public function DeleteMessage(MessageRepository $message_repository,$id){
        $message_repository->DeleteMessage($id);
        return $this->redirectToRoute('app_admin_controlleur',[]);
    }


}
