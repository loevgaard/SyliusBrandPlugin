<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface BrandInterface extends ResourceInterface, ProductsAwareInterface, ImagesAwareInterface
{
    /**
     * Returns the name of the brand
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * @return int
     */
    public function getId(): ?int;

    /**
     * @return string|null
     */
    public function getSlug(): ?string;

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void;
}
