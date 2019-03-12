<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Sylius\Component\Core\Model\ImageInterface;

interface BrandImageInterface extends ImageInterface, BrandAwareInterface
{
}
