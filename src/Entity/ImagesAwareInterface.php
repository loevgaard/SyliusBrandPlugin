<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Sylius\Component\Core\Model\ImagesAwareInterface as BaseImagesAwareInterface;

interface ImagesAwareInterface extends BaseImagesAwareInterface
{
    public function initializeImagesCollection(): void;
}
