<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait ProductsAwareTrait
{
    /**
     * @var Collection|ProductInterface[]
     */
    protected $products;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function hasProducts(): bool
    {
        return $this->products->count() > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function hasProduct(ProductInterface $product): bool
    {
        return $this->products->contains($product);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function addProduct(ProductInterface $product): void;

    /**
     * {@inheritdoc}
     */
    abstract public function removeProduct(ProductInterface $product): void;
}
