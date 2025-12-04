<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Loevgaard\SyliusBrandPlugin\Menu\AdminMenuListener;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('loevgaard_sylius_brand.listener.admin.menu_builder', AdminMenuListener::class)
            ->tag('kernel.event_listener', ['event' => 'sylius.menu.admin.main', 'method' => 'addAdminMenuItems'])
    ;
};
