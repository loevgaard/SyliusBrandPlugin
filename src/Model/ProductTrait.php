<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

trait ProductTrait
{
    protected $brand;

    /**
     * {@inheritdoc}
     */
    public function getBrand(): ?BrandInterface
    {
        return $this->brand;
    }

    /**
     * {@inheritdoc}
     */
    public function setBrand(?BrandInterface $brand): void
    {
        $this->brand = $brand;
    }
}
