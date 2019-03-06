<?php

namespace App\Repository;

use App\Entity\Dead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Dead|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dead|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dead[]    findAll()
 * @method Dead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dead::class);
    }

    // /**
    //  * @return Dead[] Returns an array of Dead objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dead
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
