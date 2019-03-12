<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Model;

use Loevgaard\SyliusBrandPlugin\Model\ProductInterface as LoevgaardSyliusBrandPluginProductInterface;
use Loevgaard\SyliusBrandPlugin\Model\ProductTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements LoevgaardSyliusBrandPluginProductInterface
{
    use ProductTrait;
}
