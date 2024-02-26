<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Doctrine\Common\Collections\Collection;

interface ProductsAwareInterface
{
    public function hasProducts(): bool;

    /**
     * @return Collection|ProductInterface[]
     */
    public function getProducts(): Collection;

    public function hasProduct(ProductInterface $product): bool;

    public function addProduct(ProductInterface $product): void;

    public function removeProduct(ProductInterface $product): void;
}
