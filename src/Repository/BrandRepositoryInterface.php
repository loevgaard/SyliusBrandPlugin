<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Repository;

use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{
    /**
     * Will find a brand by its slug
     *
     * @param string $slug
     *
     * @return BrandInterface|null
     */
    public function findOneBySlug(string $slug): ?BrandInterface;

    /**
     * Will return the brands matching $name
     *
     * @param string $name
     *
     * @return array
     */
    public function findByName(string $name): array;
}
