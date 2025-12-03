<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Loevgaard\SyliusBrandPlugin\Model\ProductInterface;

trait ProductRepositoryTrait
{
    abstract public function createQueryBuilder(string $alias, ?string $indexBy = null): QueryBuilder;

    /**
     * @return iterable<ProductInterface>
     */
    public function createPaginatorForBrand(BrandInterface $brand): iterable
    {
        /** @var iterable<ProductInterface> $result */
        $result = $this->createQueryBuilder('o')
            ->where('o.brand = :brand')
            ->setParameter('brand', $brand)
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }
}
