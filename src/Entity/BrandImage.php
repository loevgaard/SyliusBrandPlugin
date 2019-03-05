<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Sylius\Component\Core\Model\Image;

class BrandImage extends Image implements BrandImageInterface
{
    public const TYPE_LOGO = 'logo';

    public function isLogo(): bool
    {
        return $this->getType() === self::TYPE_LOGO;
    }

    /**
     * {@inheritdoc}
     */
    public function getBrand(): ?BrandInterface
    {
        /** @var BrandInterface|null $brand */
        $brand = $this->getOwner();

        return $brand;
    }

    /**
     * {@inheritdoc}
     */
    public function setBrand(?BrandInterface $brand): void
    {
        $this->setOwner($brand);
    }
}
