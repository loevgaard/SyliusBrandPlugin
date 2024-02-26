<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Menu;

use Sylius\Bundle\AdminBundle\Event\ProductMenuBuilderEvent;

final class AdminProductFormMenuListener
{
    public function addItems(ProductMenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('brand')
            ->setAttribute('template', '@LoevgaardSyliusBrandPlugin/Admin/Product/_brand.html.twig')
            ->setLabel('loevgaard_sylius_brand.ui.brand')
        ;
    }
}
