<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BrandImageRepository extends EntityRepository implements BrandImageRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function createListQueryBuilder(string $brandCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('brand')
            ->innerJoin('o.owner', 'brand', 'WITH', 'brand.code = :brandCode')
            ->setParameter('brandCode', $brandCode)
        ;
    }

    /**
     * @inheritdoc
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
