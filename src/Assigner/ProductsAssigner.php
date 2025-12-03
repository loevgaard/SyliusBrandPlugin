<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Assigner;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;

final class ProductsAssigner implements ProductsAssignerInterface
{
    public function assign(BrandInterface $brand, array $products): void
    {
        foreach ($products as $product) {
            $brand->addProduct($product);
        }
    }
}
