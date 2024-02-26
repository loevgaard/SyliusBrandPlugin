<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface BrandInterface extends ResourceInterface, CodeAwareInterface, ProductsAwareInterface, ImagesAwareInterface
{
    /**
     * Returns the name of the brand
     */
    public function __toString(): string;

    /**
     * @return int
     */
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(?string $name): void;
}
