<?php

namespace App\Repository;

use App\Entity\PlaneModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlaneModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaneModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaneModel[]    findAll()
 * @method PlaneModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaneModelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlaneModel::class);
    }

    // /**
    //  * @return PlaneModel[] Returns an array of PlaneModel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlaneModel
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
