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
    private $brand;

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
