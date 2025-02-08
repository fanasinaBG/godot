<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

//    /**
//     * @return Commande[] Returns an array of Commande objects
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

//    public function findOneBySomeField($value): ?Commande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



    public function getTotalVentes(): int
    {
        return (int) $this->createQueryBuilder('c')
            ->select('SUM(c.prixTotal)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalPlatsServis(): int
    {
        return (int) $this->createQueryBuilder('c')
            ->select('SUM(r.nombre)')
            ->join('c.relationplatCommandes', 'r')  // Utilisation du bon nom de la propriété
            ->where('c.statue = :statut')  // Vérifie bien que c'est `Statue` et non `statue`
            ->setParameter('statut', 'Livrée')
            ->getQuery()
            ->getSingleScalarResult();
    }



}
