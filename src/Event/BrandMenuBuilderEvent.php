<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class BrandMenuBuilderEvent extends MenuBuilderEvent
{
    /** @var BrandInterface */
    private $brand;

    public function __construct(FactoryInterface $factory, ItemInterface $menu, BrandInterface $brand)
    {
        parent::__construct($factory, $menu);

        $this->brand = $brand;
    }

    public function getBrand(): BrandInterface
    {
        return $this->brand;
    }
}
