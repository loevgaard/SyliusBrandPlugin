<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Factory;

use Loevgaard\SyliusBrandPlugin\Model\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface BrandImageFactoryInterface extends FactoryInterface
{
    public function createForBrand(BrandInterface $brand): BrandImageInterface;
}
