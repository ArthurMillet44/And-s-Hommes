<?php

namespace App\Repository;

use App\Entity\Panier;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Panier>
 *
 * @method Panier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panier[]    findAll()
 * @method Panier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

//Nous permets de interagir avec la table Panier dans la Base de données.

class PanierRepository extends ServiceEntityRepository
{
    private $connexion;
    public function __construct(ManagerRegistry $registry,Connection $connexion)
    {
        parent::__construct($registry, Panier::class);
        $this->connexion = $connexion;
    }


    public function countPaniersForUser(User $user)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function AjouterPanier($id_prod,$id_user){
        $this->connexion->executeQuery('CALL AjouterAuPanier(?,?)',[$id_user,$id_prod]);
    }

    public function AugmenterQuantite($id_panier){
        $this->connexion->executeQuery('CALL AugmenterQuantitePanier(?)',[$id_panier]);
    }

    public function BaisserQuantite($id_panier){
        $this->connexion->executeQuery('CALL BaisserQuantitePanier(?)',[$id_panier]);
    }

    public function DeleteProduitPanier($id_produit,$id_user)
    {
        $this->connexion->executeQuery('CALL SupprimerLignePanierParId(?,?)', [$id_produit,$id_user]);

    }
}
