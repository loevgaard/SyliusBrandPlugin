<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

trait ProductTrait
{
    protected $brand;

    /**
     * @return BrandInterface|null
     */
    public function getBrand(): ?BrandInterface
    {
        return $this->brand;
    }

    /**
     * @param BrandInterface|null $brand
     */
    public function setBrand(?BrandInterface $brand): void
    {
        $this->brand = $brand;
    }
}
