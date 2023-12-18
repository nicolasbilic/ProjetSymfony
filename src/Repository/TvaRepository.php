<?php

namespace App\Repository;

use App\Entity\Tva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tva>
 *
 * @method Tva|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tva|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tva[]    findAll()
 * @method Tva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TvaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tva::class);
    }

//    /**
//     * @return Tva[] Returns an array of Tva objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tva
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
