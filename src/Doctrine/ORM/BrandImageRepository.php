<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BrandImageRepository extends EntityRepository implements BrandImageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createPaginatorForBrand(BrandInterface $brand): iterable
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->andWhere('o.owner = :brand')
            ->setParameter('brand', $brand)
        ;

        return $this->getPaginator($queryBuilder);
    }

    /**
     * {@inheritdoc}
     */
    public function createPaginatorForBrandAndType(BrandInterface $brand, string $type): iterable
    {
        $queryBuilder = $this->createQueryBuilder('o')

            ->andWhere('o.type = :type')
            ->setParameter('type', $type)

            ->andWhere('o.owner = :brand')
            ->setParameter('brand', $brand)
        ;

        return $this->getPaginator($queryBuilder);
    }
}
