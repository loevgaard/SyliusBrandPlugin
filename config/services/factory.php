<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Loevgaard\SyliusBrandPlugin\Factory\BrandImageFactory;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('loevgaard_sylius_brand.custom_factory.brand_image', BrandImageFactory::class)
            ->decorate('loevgaard_sylius_brand.factory.brand_image', null, 256)
            ->args([
                service('.inner'),
            ])
    ;
};
