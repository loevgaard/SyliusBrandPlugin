<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Repository;

use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{
    public function findOneBySlug(string $slug): ?BrandInterface;
}