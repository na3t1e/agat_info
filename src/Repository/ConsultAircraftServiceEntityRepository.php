<?php

namespace App\Repository;

use App\Entity\ConsultAircraftServiceEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConsultAircraftServiceEntity>
 *
 * @method ConsultAircraftServiceEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsultAircraftServiceEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsultAircraftServiceEntity[]    findAll()
 * @method ConsultAircraftServiceEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultAircraftServiceEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsultAircraftServiceEntity::class);
    }

    public function save(ConsultAircraftServiceEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConsultAircraftServiceEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConsultAircraftServiceEntity[] Returns an array of ConsultAircraftServiceEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConsultAircraftServiceEntity
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
