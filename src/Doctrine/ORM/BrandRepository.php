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

    /**
     * {@inheritdoc}
     */
    public function findByPhrase(string $phrase): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :phrase OR o.slug LIKE :phrase')
            ->setParameter('phrase', '%' . $phrase . '%')
            ->getQuery()
            ->getResult()
            ;
    }
}
