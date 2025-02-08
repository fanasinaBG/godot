<?php
namespace App\Repository;

use App\Entity\StockIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockIngredient>
 */
class StockIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockIngredient::class);
    }

    public function findStockWithIngredients()
    {
        return $this->createQueryBuilder('stock')
            ->leftJoin('stock.ingredient', 'ingredient') // Utilisez la relation correctement
            ->addSelect('ingredient')
            ->getQuery()
            ->getResult();
    }
}