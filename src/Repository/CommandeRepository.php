<?php

namespace App\Repository;

use App\Controller\PanierController;
use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

//Nous permets de interagir avec la table CommandeRepository dans la Base de données.

class CommandeRepository extends ServiceEntityRepository
{
    private $connexion;
    public function __construct(ManagerRegistry $registry,Connection $connexion)
    {
        parent::__construct($registry, Commande::class);
        $this->connexion = $connexion;
    }



    public function ajouterCommandeEtSupprimerPanier($id,$code_promo){
        $this->connexion->executeQuery('CALL AjouterCommandeEtSupprimerPaniers(?,?)',[$id,$code_promo]);
    }
}
