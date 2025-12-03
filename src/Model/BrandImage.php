<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Sylius\Component\Core\Model\Image;

class BrandImage extends Image implements BrandImageInterface
{
    public const TYPE_LOGO = 'logo';

    public function isLogo(): bool
    {
        return $this->getType() === self::TYPE_LOGO;
    }

    public function getBrand(): ?BrandInterface
    {
        $owner = $this->getOwner();

        if ($owner instanceof BrandInterface) {
            return $owner;
        }

        return null;
    }

    public function setBrand(?BrandInterface $brand): void
    {
        $this->setOwner($brand);
    }
}
