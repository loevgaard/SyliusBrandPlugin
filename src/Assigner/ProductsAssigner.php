<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Assigner;

use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Loevgaard\SyliusBrandPlugin\Entity\ProductInterface;

final class ProductsAssigner implements ProductsAssignerInterface
{
    /**
     * {@inheritdoc}
     */
    public function assign(BrandInterface $brand, array $products): void
    {
        foreach ($products as $product) {
            if (!$product instanceof ProductInterface) {
                throw new \RuntimeException(sprintf(
                    "Some product was not found to assign to brand '%s'",
                    $brand->getSlug()
                ));
            }

            $brand->addProduct($product);
        }
    }
}
