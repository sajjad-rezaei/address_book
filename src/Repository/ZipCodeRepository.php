<?php

namespace App\Repository;

use App\Entity\ZipCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ZipCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZipCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZipCode[]    findAll()
 * @method ZipCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZipCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZipCode::class);
    }

    // /**
    //  * @return ZipCode[] Returns an array of ZipCode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('z.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ZipCode
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
