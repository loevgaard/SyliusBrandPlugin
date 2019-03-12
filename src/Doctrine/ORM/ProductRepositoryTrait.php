<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;

trait ProductRepositoryTrait
{
    /**
     * @param string $alias
     * @param string|null $indexBy The index for the from.
     *
     * @return QueryBuilder
     */
    abstract public function createQueryBuilder($alias, $indexBy = null);

    /**
     * {@inheritdoc}
     */
    public function createPaginatorForBrand(BrandInterface $brand): iterable
    {
        return $this->createQueryBuilder('o')
            ->where('o.brand = :brand')
            ->setParameter('brand', $brand)
            ->getQuery()
            ->getResult()
            ;
    }
}
