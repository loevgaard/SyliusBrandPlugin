<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;

interface ProductsAwareInterface
{
    public function initializeProductsCollection(): void;

    /**
     * @return Collection|BrandAwareInterface[]|ProductInterface[]
     */
    public function getProducts(): Collection;

    /**
     * @param BrandAwareInterface $product
     * @return bool
     */
    public function hasProduct(BrandAwareInterface $product): bool;

    /**
     * @param BrandAwareInterface $product
     */
    public function addProduct(BrandAwareInterface $product): void;

    /**
     * @param BrandAwareInterface $product
     */
    public function removeProduct(BrandAwareInterface $product): void;
}
