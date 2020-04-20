<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Model;

use Doctrine\ORM\Mapping as ORM;
use Loevgaard\SyliusBrandPlugin\Model\BrandImage as BaseBrandImage;

/**
 * @ORM\Entity
 * @ORM\Table(name="loevgaard_brand_image")
 */
class BrandImage extends BaseBrandImage
{
    /**
     * @ORM\Column(name="alt", length=255, nullable=true)
     *
     * @var string|null
     */
    protected $alt;

    /**
     * @return string|null
     */
    public function getAlt(): ?string
    {
        return $this->alt;
    }

    /**
     * @param string|null $alt
     */
    public function setAlt(?string $alt): void
    {
        $this->alt = $alt;
    }
}
