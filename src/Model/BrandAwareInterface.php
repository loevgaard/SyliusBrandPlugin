<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

interface BrandAwareInterface
{
    public function getBrand(): ?BrandInterface;

    public function setBrand(?BrandInterface $brand): void;
}
