<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Repository;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository implements BrandRepositoryInterface
{
    public function findByPhrase(string $phrase): array
    {
        /** @var list<BrandInterface> $result */
        $result = $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :phrase OR o.code LIKE :phrase')
            ->setParameter('phrase', '%' . $phrase . '%')
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }
}
