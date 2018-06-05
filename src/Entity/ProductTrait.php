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
     *
     * @return ProductTrait
     */
    public function setBrand(BrandInterface $brand)
    {
        $this->brand = $brand;

        return $this;
    }
}
