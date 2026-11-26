<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Loevgaard\SyliusBrandPlugin\Grid\Mutator\AdminProductGridMutator;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(AdminProductGridMutator::class)
            ->args([
                param('loevgaard_sylius_brand.model.brand.class'),
            ])
            ->tag('sylius.grid_mutator', ['grid' => 'sylius_admin_product'])
    ;
};
