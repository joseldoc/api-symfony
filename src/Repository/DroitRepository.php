<?php

namespace App\Repository;

use App\Entity\Droit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Droit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Droit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Droit[]    findAll()
 * @method Droit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DroitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Droit::class);
    }

    // /**
    //  * @return Droit[] Returns an array of Droit objects
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

    public function add(Droit $droit):void {
        $this->getEntityManager()->persist($droit);
        $this->getEntityManager()->flush();
    }

    public function delete(Droit $droit): void {
        $this->getEntityManager()->remove($droit);
        $this->getEntityManager()->flush();
    }

    public function existDroitUpdate(Droit $droit) {
        return $this->createQueryBuilder('d')
            ->andWhere('d.name = :val AND d.id <>'.$droit->getId().'')
            ->setParameter('val', $droit->getName())
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Droit
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
