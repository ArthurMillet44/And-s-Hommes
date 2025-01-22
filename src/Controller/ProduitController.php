<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends BaseController
{

    //Controlleur pour afficher la fiche produit selon le id du produit.
    #[Route('/ficheProduit/{id}', name: 'app_produit_controlleur1')]
    public function ficheProduit(ProduitRepository $repository,int $id): Response // import du repository pour pouvoir utiliser nos données
    {
        $this->addGlobalVariables();
        $produits = [$repository->find($id)];

        return $this->render('produit/fiche_produit.html.twig', [
            'produit' => $produits[0] // on passe la variable produit à la vue
        ]);
    }

    //Méthode qui renvoie le catalogue avec seulement les produits concerné par la catégorie
    #[Route('/produit/categorie/{categorie}', name: 'app_produit_categorie')]
    public function ProduitCategorie(ProduitRepository $repository, string $categorie): Response
    {
        $this->addGlobalVariables();
        $Decodecategorie = urldecode($categorie);
        $listeProduit = $repository->findBy(['categorie' => $Decodecategorie]);
        $listeSousCategorie = $this->listeSousCat($listeProduit);
        return $this->render('categorie/index.html.twig',[
            'listeProduit' => $listeProduit, //on passe la liste de produit à la vue
            'listeSousCategorie' => $listeSousCategorie, //on passe la liste de sous-categorie à la vue
            'filtre' => true
        ]);
    }


    //Méthode qui renvoie le catalogue avec seulement les produits concerné par la sous catégorie
    #[Route('/produit/SousCategorie/{categorie}/{souscategorie}', name: 'app_produit_sous_categorie')]
    public function ProduitSousCategorie(ProduitRepository $repository,string $souscategorie,string $categorie,Request $request): Response
    {
        $this->addGlobalVariables();
        $Decodesouscategorie = urldecode($souscategorie);
        $listeProduit = $repository->findBy(['sous_categorie'=>$Decodesouscategorie]);
        $Decodecategorie = urldecode($categorie);
        $listeCat = $repository->findBy(['categorie' => $Decodecategorie]);
        $listeSousCategorie = $this->listeSousCat($listeCat);
        return $this->render('categorie/index.html.twig', [
            'categorie' => $categorie,
            'listeProduit' => $listeProduit, //on passe la liste de produit à la vue
            'listeSousCategorie' => $listeSousCategorie, //on passe la liste de sous-categorie à la vue
            'filtre' => true
        ]);
    }


    //Fonction qui prend une liste de produit en paramètre et qui renvoie la liste de sous catégorie pour ces produits
    public function listeSousCat(array $listeProduit): array
    {
        $listeSousCategorie = array();
        foreach ($listeProduit as $produit){
            if (!in_array($produit->getSousCategorie(),$listeSousCategorie)){
                $listeSousCategorie[] = $produit->getSousCategorie();
            }
        }
        return $listeSousCategorie;
    }


    //Méthode qui renvoie le catalogue avec les produits concerné par le filtre
    #[Route('/produit/categorie/filtre/{categorie}', name: 'app_produit_categorie_filtre')]
    public function FiltreProduit(ProduitRepository $repository, string $categorie): Response
    {
        $this->addGlobalVariables();
        //tableau de filtre qui récupère les paramètres en post. Si ils sont vide ils valent null
        $filtres = [
            'prixMin' => isset($_POST['prixMin']) && !empty($_POST['prixMin']) ? $_POST['prixMin'] : null,
            'prixMax' => isset($_POST['prixMax']) && !empty($_POST['prixMax']) ? $_POST['prixMax'] : null,

            'sousCategorie' => isset($_POST['sousCategorie']) ? $_POST['sousCategorie'] : null ,
            'PrixCroissant' => isset($_POST['PrixCroissant']) ? $_POST['PrixCroissant'] : null,
            'PrixDecroissant' => isset($_POST['PrixDecroissant']) ? $_POST['PrixDecroissant'] : null,
            'TriAZ' => isset($_POST['TriAZ']) ? $_POST['TriAZ'] : null,
            'TriZA' => isset($_POST['TriZA']) ? $_POST['TriZA'] : null,
        ];

        // Supprime les filtres qui n'ont pas de valeur définie
        $filtres = array_filter($filtres, fn($value) => $value !== null);

        // Récupére les produits avec les filtres
        $listeProduit = $repository->getProduitsAvecFiltre($filtres,$categorie);


        $Decodecategorie = urldecode($categorie);
        $listeCat = $repository->findBy(['categorie' => $Decodecategorie]);
        $listeSousCategorie = $this->listeSousCat($listeCat);
        return $this->render('categorie/index.html.twig', [
            'listeProduit' => $listeProduit, //on passe la liste de produit à la vue
            'listeSousCategorie' => $listeSousCategorie, //on passe la liste de sous-categorie à la vue
            'filtre' => true
        ]);

    }
    #[Route('/rechercher',name:'app_rechercher')]
    public function rechercher(Request $request, ProduitRepository $produitRepository): Response{
        $this->addGlobalVariables();
        $query = $request->query->get('requete');
        $produits = $produitRepository->rechercherProduits($query);
        return $this->render("categorie/index.html.twig",[
            'listeProduit'=>$produits,
            'listeSousCategorie' => array(),
            'filtre' => false
        ]);
    }
}
