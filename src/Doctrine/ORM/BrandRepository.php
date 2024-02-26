<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository implements BrandRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function findByPhrase(string $phrase): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :phrase OR o.code LIKE :phrase')
            ->setParameter('phrase', '%' . $phrase . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
