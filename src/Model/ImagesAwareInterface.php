<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Sylius\Component\Core\Model\ImagesAwareInterface as BaseImagesAwareInterface;

interface ImagesAwareInterface extends BaseImagesAwareInterface
{
    public function initializeImagesCollection(): void;
}
