<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;

trait ProductRepositoryTrait
{
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
