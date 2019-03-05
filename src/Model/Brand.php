<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

class Brand implements BrandInterface
{
    use ProductsAwareTrait {
        ProductsAwareTrait::__construct as private __productsAwareTraitConstruct;
    }
    use ImagesAwareTrait {
        ImagesAwareTrait::__construct as private __imagesAwareTraitConstruct;
    }

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $slug;

    /**
     * @var string|null
     */
    protected $name;

    public function __construct()
    {
        $this->__imagesAwareTraitConstruct();
        $this->__productsAwareTraitConstruct();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return (string) $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function addProduct(ProductInterface $product): void
    {
        if (!$this->hasProduct($product)) {
            $product->setBrand($this);
            $this->products->add($product);
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if ($this->hasProduct($product)) {
            $product->setBrand(null);
            $this->products->removeElement($product);
        }
    }
}
