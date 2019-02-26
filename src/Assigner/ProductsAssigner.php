<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Assigner;

use Loevgaard\SyliusBrandPlugin\Entity\ProductsAwareInterface;

final class ProductsAssigner implements ProductsAssignerInterface
{
    /**
     * {@inheritdoc}
     */
    public function assign(ProductsAwareInterface $productsAware, array $products): void
    {
        foreach ($products as $product) {
            $productsAware->addProduct($product);
        }
    }
}
