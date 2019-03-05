<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

interface BrandAwareInterface
{
    /**
     * @return BrandInterface|null
     */
    public function getBrand(): ?BrandInterface;

    /**
     * @param BrandInterface|null $brand
     */
    public function setBrand(?BrandInterface $brand): void;
}
