<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Loevgaard\SyliusBrandPlugin\EventSubscriber\BrandDeletionSubscriber;
use Loevgaard\SyliusBrandPlugin\EventSubscriber\ImageUploadSubscriber;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(BrandDeletionSubscriber::class)
            ->args([
                service('sylius.repository.product'),
            ])
            ->tag('kernel.event_subscriber')

        ->set(ImageUploadSubscriber::class)
            ->args([
                service(ImageUploaderInterface::class),
            ])
            ->tag('kernel.event_subscriber')
    ;
};
