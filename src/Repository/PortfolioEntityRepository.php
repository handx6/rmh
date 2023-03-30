<?php

namespace App\Repository;

use App\Entity\PortfolioEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortfolioEntity>
 *
 * @method PortfolioEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortfolioEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortfolioEntity[]    findAll()
 * @method PortfolioEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortfolioEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortfolioEntity::class);
    }

    public function save(PortfolioEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PortfolioEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PortfolioEntity[] Returns an array of PortfolioEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PortfolioEntity
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
