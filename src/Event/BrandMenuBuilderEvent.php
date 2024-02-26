<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class BrandMenuBuilderEvent extends MenuBuilderEvent
{
    public function __construct(FactoryInterface $factory, ItemInterface $menu, private readonly BrandInterface $brand)
    {
        parent::__construct($factory, $menu);
    }

    public function getBrand(): BrandInterface
    {
        return $this->brand;
    }
}
