<?php

namespace App\Repository;

use App\Entity\ContactForProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactForProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactForProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactForProperty[]    findAll()
 * @method ContactForProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactForPropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactForProperty::class);
    }

    // /**
    //  * @return ContactForProperty[] Returns an array of ContactForProperty objects
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
    public function findOneBySomeField($value): ?ContactForProperty
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
