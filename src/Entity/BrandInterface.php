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
     * @return string
     */
    public function getSlug(): ?string;

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void;

    /**
     * @return string
     */
    public function getName(): ?string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;
}
