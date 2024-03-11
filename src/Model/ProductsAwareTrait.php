<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait ProductsAwareTrait
{
    /** @var Collection<array-key, ProductInterface> */
    protected Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function hasProducts(): bool
    {
        return $this->products->count() > 0;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function hasProduct(ProductInterface $product): bool
    {
        return $this->products->contains($product);
    }

    abstract public function addProduct(ProductInterface $product): void;

    abstract public function removeProduct(ProductInterface $product): void;
}
