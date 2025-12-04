<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Loevgaard\SyliusBrandPlugin\Fixture\BrandFixture;
use Loevgaard\SyliusBrandPlugin\Fixture\Factory\BrandExampleFactory;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('loevgaard_sylius_brand.fixture.brand', BrandFixture::class)
            ->args([
                service('loevgaard_sylius_brand.manager.brand'),
                service('loevgaard_sylius_brand.fixture.example_factory.brand'),
            ])
            ->tag('sylius_fixtures.fixture')

        ->set('loevgaard_sylius_brand.fixture.example_factory.brand', BrandExampleFactory::class)
            ->args([
                service('sylius.repository.product'),
                service('loevgaard_sylius_brand.factory.brand'),
                service('loevgaard_sylius_brand.factory.brand_image'),
                service(ImageUploaderInterface::class),
                service('file_locator'),
            ])
    ;
};
