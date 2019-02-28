<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Assigner;

use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Loevgaard\SyliusBrandPlugin\Entity\ProductInterface;

interface ProductsAssignerInterface
{
    /**
     * @param BrandInterface $brand
     * @param ProductInterface[]|array $products
     */
    public function assign(BrandInterface $brand, array $products): void;
}
