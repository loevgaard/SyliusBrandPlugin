<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Sylius\Component\Core\Model\Image;

class BrandImage extends Image
{
    const TYPE_LOGO = 'logo';

    public function isLogo(): bool
    {
        return $this->getType() === self::TYPE_LOGO;
    }
}
