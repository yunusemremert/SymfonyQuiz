<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByOrderProducts($userId)
    {
        return $this->createQueryBuilder('o')
            ->select('o.id, p.name, p.amount, o.amount total_amount, o.quantity')
            ->innerJoin(Product::class, 'p', Join::WITH, 'p.id = o.product_id')
            ->andWhere('o.user_id = :user_id')
            ->andWhere('o.no IS NULL')
            ->orderBy('o.id', 'DESC')
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getResult();
    }

    public function updateByOrder(array $data): void
    {
        $this->createQueryBuilder('o')
            ->update()
            ->set('o.no', ':no')
            ->set('o.adress', ':adress')
            ->set('o.payment_method', ':paymentMethod')
            ->where('o.user_id=:userId')
            ->andWhere('o.no IS NULL')
            ->setParameters($data)
            ->getQuery()
            ->execute();
    }
}
