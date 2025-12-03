<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<BrandInterface>
 */
interface BrandRepositoryInterface extends RepositoryInterface
{
    /**
     * @return list<BrandInterface>
     */
    public function findByPhrase(string $phrase): array;
}
