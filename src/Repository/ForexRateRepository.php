<?php

namespace App\Repository;

use App\Entity\ForexRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ForexRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForexRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForexRate[]    findAll()
 * @method ForexRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForexRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForexRate::class);
    }

    // /**
    //  * @return ForexRate[] Returns an array of ForexRate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ForexRate
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
