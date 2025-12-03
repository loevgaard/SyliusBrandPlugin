<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Loevgaard\SyliusBrandPlugin\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;

/**
 * @extends BaseProductRepositoryInterface<ProductInterface>
 */
interface ProductRepositoryInterface extends BaseProductRepositoryInterface
{
    /**
     * @return iterable<ProductInterface>
     */
    public function createPaginatorForBrand(BrandInterface $brand): iterable;
}
