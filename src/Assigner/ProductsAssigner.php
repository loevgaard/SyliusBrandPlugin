<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

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
            if (null !== $product) {
                $productsAware->addProduct($product);
            }
        }
    }
}
