<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Factory;

use Loevgaard\SyliusBrandPlugin\Entity\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class BrandImageFactory implements BrandImageFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew(): BrandImageInterface
    {
        /** @var BrandImageInterface $brandImage */
        $brandImage = $this->factory->createNew();

        return $brandImage;
    }

    /**
     * {@inheritdoc}
     */
    public function createForBrand(BrandInterface $brand): BrandImageInterface
    {
        /** @var BrandImageInterface $brandImage */
        $brandImage = $this->createNew();
        $brandImage->setBrand($brand);

        return $brandImage;
    }
}
