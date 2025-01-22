<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\CodePromoRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;

use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends BaseController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(PanierRepository $panierRepository,ProduitRepository $produitRepository,CodePromoRepository $codePromoRepository,Request $request): Response
    {
        //Permet d'accéder à panier uniquement si on est connecter
        if ($this->isGranted('ROLE_USER')) {
            $this->addGlobalVariables();

            //Appelle Une méthode Annexe, expliquée en dessou.
            $resultat=$this->get_produits_paniers_user($panierRepository,$produitRepository);
            $panier=$resultat[0];
            $Quantite_Produits_Choisis=$resultat[1];

            //IDEM
            $compteur_Produit=$this->get_nombres_produits($panierRepository);
            

            //IDEM
            $prix_SousTotal=$this->get_Prix_Soustotal($panierRepository,$produitRepository);

            $codePromo = $request->request->get('input_code_promo');

            // Si un code promo est fourni, appliquer la réduction
            $codePromoEntity = null;
            $code_promo_reduction = null;
            $prix_total_apres_reduction = $prix_SousTotal;

            if (!empty($codePromo)) {
                $codePromoEntity = $codePromoRepository->findOneBy(['nom_code' => $codePromo]);

                // Vérifier si le code promo existe et est encore utilisable
                if ($codePromoEntity && $codePromoEntity->getNbrUse() > 0) {
                    $code_promo_reduction = $codePromoEntity->getPourcentage();
                    $prix_total_apres_reduction = $prix_SousTotal - ($prix_SousTotal * $code_promo_reduction / 100);
                }
            }


            //La vue panier à besoin de beaucoup de paramètres car à besoin de beaucoup d'infos (souvent venue de la base ou de calcul)
            return $this->render('panier/index.html.twig', [
                'controller_name' => 'PanierController',
                'panier_User' => $panier,
                'quantite_produit'=> $Quantite_Produits_Choisis,
                'nombre_produits'=>$compteur_Produit,
                'prix_SousTotal'=>$prix_SousTotal,
                'code_promo_reduction' => $code_promo_reduction,
                'prix_total_apres_reduction' => $prix_total_apres_reduction,
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }
    //FONCTIONS ANNEXES POUR INDEX

    //Permet d'aller récupérer toutes informations des produits situé dans le panier de l'utilsateur.
    public function get_produits_paniers_user(PanierRepository $panierRepository,ProduitRepository $produitRepository){


        $user=$this->getUser();
        $panierID=$panierRepository->findBy(["user"=>$user]);
        $panier=array();
        $Quantite_Produits_Choisis=array();

        //Double boucle qui permet dans un premier temps de parcourir tou
        foreach ($panierID as $produitID){

            $Allproduits=$produitRepository->findAll();

            foreach($Allproduits as $produit){

                if ($produit->getId()==$produitID->getProduit()->getId()){

                    $panier[]=$produit;
                    $Quantite_Produits_Choisis[]=$produitID->getQuantite();

                }
            }
        }
        return array($panier,$Quantite_Produits_Choisis);
    }

    //Permet d'aller récupérer le nombre total de produit dans le panier pour pouvoir l'afficher.
    public function get_nombres_produits(PanierRepository $panierRepository):int{
        $user=$this->getUser();
        $panierID=$panierRepository->findBy(["user"=>$user]);
        $compteurProduits=0;
        foreach($panierID as $ligne){
            $compteurProduits=$compteurProduits+ $ligne->getQuantite();
        }
        return $compteurProduits;
    }

    //Permet de récupérer le prix total de tous les produits cumulés.
    public function get_Prix_Soustotal(PanierRepository $panierRepository,ProduitRepository $produitRepository):float{
        $user=$this->getUser();
        $panierID=$panierRepository->findBy(["user"=>$user]);
        $prixTotal=0.0;
        foreach($panierID as $ligne){
            $produit_trouve=$produitRepository->findBy(["id"=>$ligne->getProduit()->getId()]);
            $quantite_prise=$ligne->getQuantite();
            foreach($produit_trouve as $produit)
                $prixTotal=$prixTotal + ($produit->getPrix()*$quantite_prise);
        }

        return $prixTotal;
    }


    //FIN FONCTIONS ANNEXES POUR INDEX

    //Increment quand le + est appuyé sur le bouton
    #[Route('/panier/augmenter/{id}', name: 'augmenter_produit_panier')]

    public function addQuantite(EntityManagerInterface $entityManager,PanierRepository $panierRepository,ProduitRepository $produitRepository,int $id)
    {
        $user=$this->getUser();
        $produit = $produitRepository->find($id);
        //On trouve le produit selon l'id du user et l'id du produit.
        $produit_panier=$panierRepository->findBy(["user"=>$user,"produit"=>$produit]);

        //Si jamais le produit dans la base à un stock égal à la quantité prise
        //Sinon on appel notre procédure pour augmenter la quantité.
        $panierRepository->AugmenterQuantite($produit_panier[0]->getId());

        return $this->redirectToRoute('app_panier');
    }




    //Increment quand le - est appuyé sur un bouton

    #[Route('/panier/diminuer/{id}', name: 'diminuer_produit_panier')]

    public function deleteQuantite(EntityManagerInterface $entityManager,PanierRepository $panierRepository,ProduitRepository $produitRepository,int $id)
    {
        //La fonction a une structure strictement identique à celle du dessu.
        $user=$this->getUser();
        $produit = $produitRepository->find($id);
        $produit_ID=$panierRepository->findBy(["user"=>$user,"produit"=>$produit]);

        //procédure permettant de baisser la quantité et de la supprimer si elle est à 0
        $panierRepository->BaisserQuantite($produit_ID[0]->getId());

        return $this->redirectToRoute('app_panier');
    }


    //Méthode qui sert à "actualisé" la vue avec le nombre d'élément dans le panier
    #[Route('/panier/count', name: 'panier_count')]
    public function nombreProduit(PanierRepository $panierRepository): JsonResponse
    {
        return  $this->addGlobalVariables();
    }

    //Supprimer  un produit du panier (avec l'icone de poubelle)
    #[Route('/panier/supprimer/{id}', name: 'delete_produit_panier')]
    public function supprimerProduitPanier(PanierRepository $panierRepository,int $id){
        $panierRepository->DeleteProduitPanier($id,$this->getUser()->getId());
        return $this->redirectToRoute('app_panier');
    }


    #[Route('/panier/code-promo-reduction', name: 'panier_code_promo_reduction')]
    public function getCodePromoReduction(Request $request, CodePromoRepository $codePromoRepository,PanierRepository $panierRepository,ProduitRepository $produitRepository): JsonResponse
    {
        $codePromo = $request->query->get('code_promo');
        $codePromoEntity = $codePromoRepository->findOneBy(['nom_code' => $codePromo]);

        $response = [
            'code_promo_reduction' => null,
            'prix_SousTotal' => $this->get_Prix_Soustotal($panierRepository, $produitRepository),
        ];

        if ($codePromoEntity && $codePromoEntity->getNbrUse() > 0) {
            $response['code_promo_reduction'] = $codePromoEntity->getPourcentage();
            $response['prix_total_apres_reduction'] = $response['prix_SousTotal'] - ($response['prix_SousTotal'] * $codePromoEntity->getPourcentage() / 100);
        }

        return new JsonResponse($response);
    }
}
