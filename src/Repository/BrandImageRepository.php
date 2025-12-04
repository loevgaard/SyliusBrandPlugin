<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Loevgaard\SyliusBrandPlugin\Model\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Pagerfanta\PagerfantaInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BrandImageRepository extends EntityRepository implements BrandImageRepositoryInterface
{
    public function createListQueryBuilder(string $brandCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('brand')
            ->innerJoin('o.owner', 'brand', 'WITH', 'brand.code = :brandCode')
            ->setParameter('brandCode', $brandCode)
        ;
    }

    /**
     * @return PagerfantaInterface<BrandImageInterface>
     */
    public function createPaginatorForBrandAndType(BrandInterface $brand, string $type): PagerfantaInterface
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
