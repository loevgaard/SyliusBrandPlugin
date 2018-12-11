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
     * @param BrandInterface|null $brand
     */
    public function setBrand(BrandInterface $brand = null): void
    {
        $this->brand = $brand;
    }
}
