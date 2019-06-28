<?php

namespace App\Repository;

use App\Entity\Properties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Properties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Properties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Properties[]    findAll()
 * @method Properties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertiesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Properties::class);
    }

    /**
     * @param $limit
     * @param $accept
     * @return Properties[]
     */
    public function findLastProperties($limit, $accept)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->andWhere('p.approved = :accept')
            ->setParameter(':accept', $accept)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Properties[] Returns an array of Properties objects
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
    public function findOneBySomeField($value): ?Properties
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
