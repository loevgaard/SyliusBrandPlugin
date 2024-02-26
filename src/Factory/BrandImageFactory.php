<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Factory;

use Loevgaard\SyliusBrandPlugin\Model\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class BrandImageFactory implements BrandImageFactoryInterface
{
    public function __construct(private readonly FactoryInterface $factory)
    {
    }

    /**
     * @inheritdoc
     */
    public function createNew(): BrandImageInterface
    {
        /** @var BrandImageInterface $brandImage */
        $brandImage = $this->factory->createNew();

        return $brandImage;
    }

    /**
     * @inheritdoc
     */
    public function createForBrand(BrandInterface $brand): BrandImageInterface
    {
        /** @var BrandImageInterface $brandImage */
        $brandImage = $this->createNew();
        $brandImage->setBrand($brand);

        return $brandImage;
    }
}
