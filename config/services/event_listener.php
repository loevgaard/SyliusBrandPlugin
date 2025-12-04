<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Sylius\Bundle\CoreBundle\EventListener\ImagesUploadListener;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('loevgaard_sylius_brand.listener.images_upload', ImagesUploadListener::class)
            ->parent('sylius.listener.images_upload')
            ->tag('kernel.event_listener', ['event' => 'loevgaard_sylius_brand.brand.pre_create', 'method' => 'uploadImages'])
            ->tag('kernel.event_listener', ['event' => 'loevgaard_sylius_brand.brand.pre_update', 'method' => 'uploadImages'])
    ;
};
