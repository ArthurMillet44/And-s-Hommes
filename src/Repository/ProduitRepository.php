<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */


//Nous permets de interagir avec la table Produit dans la Base de données.

class ProduitRepository extends ServiceEntityRepository{
    private $connexion;
    public function __construct(ManagerRegistry $registry,Connection $connexion)
    {
        parent::__construct($registry, Produit::class);
        $this->connexion = $connexion;
    }



    //Récupère dans la base de donnée les produits en fonction des filtres et de la catégorie
    public function getProduitsAvecFiltre(array $filtres, string $categorie)
    {

        $qb = $this->createQueryBuilder('p');

        $qb->andWhere('p.categorie = :categorie')
            ->setParameter('categorie', $categorie);
        if (isset($filtres['prixMin'])){
            $qb->andWhere('p.prix >= :prixMin')
                ->setParameter('prixMin', $filtres['prixMin']);
        }
        if (isset($filtres['prixMax'])) {
            $qb->andWhere('p.prix <= :prixMax')
                ->setParameter('prixMax', $filtres['prixMax']);
        }
        if (isset($filtres['sousCategorie'])){
            $qb->andWhere('p.sous_categorie = :sousCetegorie')
                ->setParameter('sousCetegorie', $filtres['sousCategorie']);

        }

        if (isset($filtres['PrixCroissant'])){
            $qb->addOrderBy('p.prix', 'ASC');
        }
        if (isset($filtres['PrixDecroissant'])){
            $qb->addOrderBy('p.prix', 'DESC');
        }
        if (isset($filtres['TriAZ'])){
            $qb->addOrderBy('p.nom', 'ASC');
        }
        if (isset($filtres['TriZA'])){
            $qb->addOrderBy('p.nom', 'DESC');
        }



        return $qb->getQuery()->getResult();
    }


    public function ModifierProduit($id,$nom,$prix,$quantite,$description,$categorie,$sous_categorie,$image){
        $this->connexion->executeQuery('CALL ModifierProduit(?,?,?,?,?,?,?,?)',[$id,$nom,$prix,$quantite,$description,$categorie,$sous_categorie,$image]);
    }

    public function DeleteProduit($id){
        $this->connexion->executeQuery('CALL SupprimerProduit(?)',[$id]);
    }

    public function rechercherProduits($query)
    {
        return $this->createQueryBuilder('p')
            ->where('p.nom LIKE :requete')
            ->setParameter('requete', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }


}
