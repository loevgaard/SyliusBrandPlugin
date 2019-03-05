<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface ProductsAwareInterface
{
    public function initializeProductsCollection(): void;

    /**
     * @return bool
     */
    public function hasProducts(): bool;

    /**
     * @return Collection|ProductInterface[]
     */
    public function getProducts(): Collection;

    /**
     * @param ProductInterface $product
     *
     * @return bool
     */
    public function hasProduct(ProductInterface $product): bool;

    /**
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product): void;

    /**
     * @param ProductInterface $product
     */
    public function removeProduct(ProductInterface $product): void;
}
