<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

trait ProductTrait
{
    /**
     * @var BrandInterface
     */
    protected $brand;

    /**
     * @return BrandInterface
     */
    public function getBrand(): ?BrandInterface
    {
        return $this->brand;
    }

    /**
     * @param BrandInterface $brand
     */
    public function setBrand(BrandInterface $brand): void
    {
        $this->brand = $brand;
    }
}
