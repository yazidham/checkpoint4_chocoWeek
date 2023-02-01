<?php

namespace App\Repository;

use App\Entity\NumberOfCoins;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NumberOfCoins>
 *
 * @method NumberOfCoins|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumberOfCoins|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumberOfCoins[]    findAll()
 * @method NumberOfCoins[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumberOfCoinsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NumberOfCoins::class);
    }

    public function save(NumberOfCoins $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NumberOfCoins $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NumberOfCoins[] Returns an array of NumberOfCoins objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NumberOfCoins
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
