<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository implements BrandRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o');
    }
}
