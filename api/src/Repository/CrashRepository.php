<?php

namespace App\Repository;

use App\Entity\Crash;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Crash|null find($id, $lockMode = null, $lockVersion = null)
 * @method Crash|null findOneBy(array $criteria, array $orderBy = null)
 * @method Crash[]    findAll()
 * @method Crash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrashRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Crash::class);
    }

    // /**
    //  * @return Crash[] Returns an array of Crash objects
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
    public function findOneBySomeField($value): ?Crash
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
