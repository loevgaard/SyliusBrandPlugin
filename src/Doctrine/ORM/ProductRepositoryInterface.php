<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;

interface ProductRepositoryInterface extends BaseProductRepositoryInterface
{
    public function createPaginatorForBrand(BrandInterface $brand): iterable;
}
