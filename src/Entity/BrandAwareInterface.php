<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

interface BrandAwareInterface
{
    /**
     * @return BrandInterface
     */
    public function getBrand(): ?BrandInterface;

    /**
     * @param BrandInterface|null $brand
     */
    public function setBrand(BrandInterface $brand = null): void;
}
