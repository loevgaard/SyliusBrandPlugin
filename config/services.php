<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->import('services/event_listener.php');
    $container->import('services/event_subscriber.php');
    $container->import('services/factory.php');
    $container->import('services/fixture.php');
    $container->import('services/form.php');
    $container->import('services/menu.php');
    $container->import('services/twig_component.php');
};
