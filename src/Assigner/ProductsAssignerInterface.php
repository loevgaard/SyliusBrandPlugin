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
