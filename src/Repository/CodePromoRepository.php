<?php

namespace App\Repository;

use App\Entity\CodePromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodePromo>
 *
 * @method CodePromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodePromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodePromo[]    findAll()
 * @method CodePromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

//Nous permets de interagir avec la table CodePromo dans la Base de données.

class CodePromoRepository extends ServiceEntityRepository
{
    private $connexion;
    public function __construct(ManagerRegistry $registry,Connection $connexion)
    {
        parent::__construct($registry, CodePromo::class);
        $this->connexion = $connexion;
    }



    public function ModifierCode($id,$pourcentage,$nbr_use,$nom_code){
        $this->connexion->executeQuery('CALL MettreAJourCodePromo(?,?,?,?)',[$id,$pourcentage,$nbr_use,$nom_code]);
    }

    public function DeleteCode($id){
        $this->connexion->executeQuery('CALL SupprimerCodePromo(?)',[$id]);
    }
}
