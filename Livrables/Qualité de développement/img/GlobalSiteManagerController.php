<?php

namespace App\Controller;

use App\Controller\AboutUsController;
use App\Controller\AdminController;
use App\Controller\BaseController;
use App\Controller\CategorieController;
use App\Controller\CommandeController;
use App\Controller\ContactController;
use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\PanierController;
use App\Controller\ProduitController;
use App\Controller\RegistrationController;
use App\Controller\UserController;
use App\Repository\CodePromoRepository;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class GlobalSiteManagerController
{
    private $aboutUsController;
    private $adminController;
    private $categorieController;
    private $commandeController;
    private $contactController;
    private $homeConroller;
    private $loginController;
    private $panierController;
    private $produitController;
    //private $registrationController;
    //private $userController;

    private $produit_repository;
    private $panier_repository;
    private $user_repository;
    private $commande_repository;
    private $code_promo_repository;

    private $entity_manager;
    private $authenticationUtils;


    public function __construct(
        AboutUsController $aboutUsController,
        AdminController $adminController,
        CategorieController $categorieController,
        CommandeController $commandeController,
        ContactController $contactController,
        HomeController $homeController,
        LoginController $loginController,
        PanierController $panierController,
        ProduitController $produitController,
        //  RegistrationController $registrationController,
        // UserController $userController,
        ProduitRepository $produitRepository,
        PanierRepository $panier_repository,
        UserRepository $user_repository,
        CommandeRepository $commande_repository,
        CodePromoRepository $code_promo_repository,
        EntityManager $entityManager,
        AuthenticationUtils $authenticationUtils){

        $this->adminController=$adminController;
        $this->aboutUsController=$aboutUsController;
        $this->categorieController=$categorieController;
        $this->commandeController=$commandeController;
        $this->contactController=$contactController;
        $this->homeConroller=$homeController;
        $this->loginController=$loginController;
        $this->panierController=$panierController;
        $this->produitController=$produitController;
        // $this->registrationController=$registrationController;

        //$this->userController=$userController;
        $this->produit_repository=$produitRepository;
        $this->panier_repository=$panier_repository;
        $this->user_repository=$user_repository;
        $this->commande_repository=$commande_repository;
        $this->code_promo_repository=$code_promo_repository;

        $this->entity_manager=$entityManager;
        $this->authenticationUtils=$authenticationUtils;

    }

    public function afficherPageAboutUs(){
        return $this->aboutUsController->index();
    }

    public function afficherPageAdmin(){
        return $this->adminController->affichagePageAdmin($this->produit_repository,$this->user_repository,$this->code_promo_repository);
    }

    public function afficherPageFormulaireAjouterProduit(){
        return $this->adminController->ajouterProduitForm();
    }

    public function ajouterUnProduit(){
        return $this->adminController->addProduct($this->entity_manager);
    }

    public function supprimerunProduit(int $id){
        return $this->adminController->deleteProduit($id,$this->produit_repository);
    }

    public function afficherPageFormulaireUpdateunProduit(int $id){
        return $this->adminController->updateProduitForm($id,$this->produit_repository);
    }

    public function modifierUnProduit(int $id){
        return $this->adminController->updateProduit($id,$this->produit_repository);
    }

    public function supprimerUnUtilisateur(int $id){
        return $this->adminController->deleteUser($id,$this->user_repository);
    }

    public function afficherPageAjouterCodePromo(int $id){
        return $this->adminController->ajouterCodeForm();
    }
    public function AjouterUnCodePromo(){
        return $this->adminController->addCode($this->entity_manager);
    }
    public function afficherPageUpdateCodePromo(int $id){
        return $this->adminController->updateCodePromo($id,$this->code_promo_repository);
    }
    public function MettreAjourCodePromo(int $id){
        return $this->adminController->updateCode($id,$this->produit_repository,$this->user_repository,$this->code_promo_repository);
    }

    public function supprimerUnCodePromo(int $id){
        return $this->adminController->deleteCode($id,$this->code_promo_repository);
    }

    public function afficherPageCategorie(){
        return $this->categorieController->index();
    }

    public function ajouterAuPanierDepuisCategorie(int $id){
        return $this->categorieController->addPanier($this->panier_repository,$id,$this->produit_repository);
    }

    public function afficherPageCommande(){
        return $this->commandeController->index($this->commande_repository);
    }

    public function ajouteUneCommande(){
        return $this->commandeController->ajoutCommande($this->commande_repository);
    }

    public function afficherPageContact(){
        return $this->contactController->index();
    }

    public function afficherPageAccueil(){
        return $this->homeConroller->index();
    }

    public function seConnecter(){
        return $this->loginController->login($this->authenticationUtils);
    }

    public function seDeconnecter(){
        return $this->loginController->logout();
    }

    public function afficherPagePanier(){
        return $this->panierController->index($this->panier_repository,$this->produit_repository,$this->code_promo_repository);
    }

    public function incrementQuantiteProduit(int $id){
        return $this->panierController->addQuantite($this->panier_repository,$this->produit_repository,$id);
    }

    public function decrementQuantiteProduit(int $id){
        return $this->panierController->deleteQuantite($this->panier_repository,$this->produit_repository,$id);
    }

    public function nombreProduitsPanier(){
        return $this->panierController->nombreProduit();
    }
    public function supprimerUnProduitduPanier(int $id){
        return $this->panierController->supprimerProduitPanier($this->panier_repository,$id);
    }

    public function afficherPageFicheProduit(int $id){
        return $this->produitController->ficheProduit($this->produit_repository,$id);
    }

    public function AfficherPageFiltreeCategorie(string $categorie){
        return $this->produitController->ProduitCategorie($this->produit_repository,$categorie);
    }
    public function AfficherPageFiltreeSousCategorie(string $categorie, string $souscategorie){
        return $this->produitController->ProduitSousCategorie($this->produit_repository,$souscategorie,$categorie);
    }

    public function AfficherPageTypeFiltrage(string $categorie){
        return $this->produitController->FiltreProduit($this->produit_repository,$categorie);
    }

}
