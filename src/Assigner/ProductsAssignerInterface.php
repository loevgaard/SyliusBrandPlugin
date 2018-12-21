<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Assigner;

use Loevgaard\SyliusBrandPlugin\Entity\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Entity\ProductsAwareInterface;

interface ProductsAssignerInterface
{
    /**
     * @param ProductsAwareInterface $productsAware
     * @param BrandAwareInterface[] $products
     */
    public function assign(ProductsAwareInterface $productsAware, array $products): void;
}
