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
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }
//
//    /**
//     * @return Transaction[] Returns an array of Transaction objects
//     */
//    public function findTransactionsById($value): array
//    {
//        return $this->createQueryBuilder('trans')
//            ->andWhere('trans.sender_account_id_id = :val')
//            ->orWhere('trans.receiver_account_id_id = :val')
//            ->setParameter('val', $value)
//            ->orderBy('trans.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult();
//    }
}
