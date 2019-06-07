<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Menu;

use Loevgaard\SyliusBrandPlugin\Event\BrandMenuBuilderEvent;

final class AdminBrandFormMenuListener
{
    public function addItems(BrandMenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('test')
            ->setAttribute('template', 'Admin/Brand/_test.html.twig')
            ->setLabel('app.ui.test')
        ;
    }
}
