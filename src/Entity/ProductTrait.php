<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ProductTrait
{
    /**
     * @var BrandInterface|null
     * @ORM\ManyToOne(targetEntity="Loevgaard\SyliusBrandPlugin\Entity\Brand", inversedBy="products")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    protected $brand;

    /**
     * {@inheritdoc}
     */
    public function getBrand(): ?ProductsAwareInterface
    {
        return $this->brand;
    }

    /**
     * {@inheritdoc}
     */
    public function setBrand(?ProductsAwareInterface $brand): void
    {
        $this->brand = $brand;
    }
}
