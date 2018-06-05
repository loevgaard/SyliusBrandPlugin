<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu
            ->getChild('catalog')
            ->addChild('brands', [
                'route' => 'loevgaard_sylius_brand_admin_brand_index',
            ])
            ->setLabel('Brands')
            ->setLabelAttribute('icon', 'building')
        ;
    }
}
