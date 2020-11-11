<?php

namespace App\Repository;

use App\Entity\Business;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Business|null find($id, $lockMode = null, $lockVersion = null)
 * @method Business|null findOneBy(array $criteria, array $orderBy = null)
 * @method Business[]    findAll()
 * @method Business[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Business::class);
    }

	/**
	 * @return Business|null
	 * @throws NonUniqueResultException
	 */
	public function findOne(): ?Business
	{
		return $this->createQueryBuilder('business')
			->select('business, bank_accounts, crypto_currency_accounts, service_accounts')
			->leftJoin('business.bankAccounts', 'bank_accounts')
			->leftJoin('business.cryptoCurrencyAccounts', 'crypto_currency_accounts')
			->leftJoin('business.serviceAccounts', 'service_accounts')
			->getQuery()
			->getOneOrNullResult()
			;
	}

}
