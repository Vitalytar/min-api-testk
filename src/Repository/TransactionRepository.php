<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 *
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @return Transaction[] Returns an array of Transaction objects
     */
    public function findTransactionsByAccountId($value, $filters = []): array
    {
        $query = $this->createQueryBuilder('t')
            ->andWhere('t.sender_account = :val')
            ->orWhere('t.receiver_account = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'DESC');

        if ($filters) {
            if (!empty($filters['limit'])) {
                $query->setMaxResults($filters['limit']);
            }

            if (!empty($filters['offset'])) {
                $query->setFirstResult($filters['offset']);
            }
        }

        return $query->getQuery()
            ->getResult();
    }
}
