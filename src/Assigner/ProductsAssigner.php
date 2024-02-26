<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Assigner;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Loevgaard\SyliusBrandPlugin\Model\ProductInterface;

final class ProductsAssigner implements ProductsAssignerInterface
{
    public function assign(BrandInterface $brand, array $products): void
    {
        foreach ($products as $product) {
            if (!$product instanceof ProductInterface) {
                throw new \RuntimeException(sprintf(
                    "Some product was not found to assign to brand '%s'",
                    $brand->getCode(),
                ));
            }

            $brand->addProduct($product);
        }
    }
}
