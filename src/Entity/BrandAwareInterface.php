<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

interface BrandAwareInterface
{
    /**
     * @return ProductsAwareInterface|null
     */
    public function getBrand(): ?ProductsAwareInterface;

    /**
     * @param ProductsAwareInterface|null $brand
     */
    public function setBrand(?ProductsAwareInterface $brand): void;
}
