<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Repository;

use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository implements BrandRepositoryInterface
{
    /**
     * @param string $slug
     *
     * @return BrandInterface|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneBySlug(string $slug): ?BrandInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
