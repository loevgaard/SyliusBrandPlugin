<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;

trait ProductsAwareTrait
{
    /** @var Collection|BrandAwareInterface[]|ProductInterface[] */
    protected $products;

    /**
     * {@inheritdoc}
     */
    public function initializeProductsCollection(): void
    {
        $this->products = new ArrayCollection();
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
    public function hasProduct(BrandAwareInterface $product): bool
    {
        return $this->products->contains($product);
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(BrandAwareInterface $product): void
    {
        if (false === $this->hasProduct($product)) {
            /** @var ProductsAwareInterface $this */
            $product->setBrand($this);
            $this->products->add($product);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(BrandAwareInterface $product): void
    {
        if (true === $this->hasProduct($product)) {
            $product->setBrand(null);
            $this->products->removeElement($product);
        }
    }
}
