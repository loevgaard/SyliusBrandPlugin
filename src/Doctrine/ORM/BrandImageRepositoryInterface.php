<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Loevgaard\SyliusBrandPlugin\Model\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<BrandImageInterface>
 */
interface BrandImageRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $brandCode): QueryBuilder;

    /**
     * @return iterable<BrandImageInterface>
     */
    public function createPaginatorForBrandAndType(BrandInterface $brand, string $type): iterable;
}
