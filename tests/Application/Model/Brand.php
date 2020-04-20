<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Model;

use Doctrine\ORM\Mapping as ORM;
use Loevgaard\SyliusBrandPlugin\Model\Brand as BaseBrand;

/**
 * @ORM\Entity
 * @ORM\Table(name="loevgaard_brand")
 */
class Brand extends BaseBrand
{
    /**
     * @ORM\Column(name="description", length=255, nullable=true)
     *
     * @var string|null
     */
    protected $description;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
