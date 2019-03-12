<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait ProductTrait
{
    /**
     * @var BrandInterface
     *
     * @ORM\ManyToOne(targetEntity="\Loevgaard\SyliusBrandPlugin\Model\BrandInterface", cascade={"all"}, fetch="EAGER", inversedBy="products")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $brand;

    /**
     * @return BrandInterface|null
     */
    public function getBrand(): ?BrandInterface
    {
        return $this->brand;
    }

    /**
     * @param BrandInterface|null $brand
     */
    public function setBrand(?BrandInterface $brand): void
    {
        $this->brand = $brand;
    }
}
