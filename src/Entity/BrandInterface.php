<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface BrandInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     * @return Brand
     */
    public function setId(int $id) : BrandInterface;

    /**
     * @return string
     */
    public function getSlug(): string;

    /**
     * @param string $slug
     * @return Brand
     */
    public function setSlug(string $slug) : BrandInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return Brand
     */
    public function setName(string $name) : BrandInterface;
}