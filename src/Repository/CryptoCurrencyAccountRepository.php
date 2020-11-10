<?php

namespace App\Repository;

use App\Entity\CryptoCurrencyAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CryptoCurrencyAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method CryptoCurrencyAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method CryptoCurrencyAccount[]    findAll()
 * @method CryptoCurrencyAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptoCurrencyAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoCurrencyAccount::class);
    }

    // /**
    //  * @return CryptoCurrencyAccount[] Returns an array of CryptoCurrencyAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CryptoCurrencyAccount
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
