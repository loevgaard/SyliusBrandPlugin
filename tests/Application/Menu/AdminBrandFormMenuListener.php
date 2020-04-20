<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Menu;

use Knp\Menu\ItemInterface;
use Loevgaard\SyliusBrandPlugin\Event\BrandMenuBuilderEvent;

final class AdminBrandFormMenuListener
{
    public function addItems(BrandMenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $detailsMenuItem = $menu->getChild('details');
        if ($detailsMenuItem instanceof ItemInterface) {
            $detailsMenuItem->setAttribute('template', 'Admin/Brand/Tab/_details.html.twig');
        }

        $mediaMenuItem = $menu->getChild('media');
        if ($mediaMenuItem instanceof ItemInterface) {
            $mediaMenuItem->setAttribute('template', 'Admin/Brand/Tab/_media.html.twig');
        }

        $menu
            ->addChild('test')
            ->setAttribute('template', 'Admin/Brand/Tab/_test.html.twig')
            ->setLabel('app.ui.tab.test')
        ;
    }
}
