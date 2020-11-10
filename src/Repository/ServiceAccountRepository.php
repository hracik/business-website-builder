<?php

namespace App\Repository;

use App\Entity\ServiceAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServiceAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceAccount[]    findAll()
 * @method ServiceAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceAccount::class);
    }

    // /**
    //  * @return ServiceAccount[] Returns an array of ServiceAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServiceAccount
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
