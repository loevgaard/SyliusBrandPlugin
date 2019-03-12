<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Doctrine\ORM;

use Loevgaard\SyliusBrandPlugin\Doctrine\ORM\ProductRepositoryInterface;
use Loevgaard\SyliusBrandPlugin\Doctrine\ORM\ProductRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    use ProductRepositoryTrait;
}
