<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    public function createListQueryBuilder(): QueryBuilder;

    /**
     * @return array|BrandInterface[]
     */
    public function findByPhrase(string $phrase): array;
}
