<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Loevgaard\SyliusBrandPlugin\Form\Type\BrandType;
use Loevgaard\SyliusBrandPlugin\Twig\Component\Brand\FormComponent;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('loevgaard_sylius_brand.twig.component.brand.form', FormComponent::class)
            ->args([
                service('loevgaard_sylius_brand.repository.brand'),
                service('form.factory'),
                param('loevgaard_sylius_brand.model.brand.class'),
                BrandType::class,
            ])
            ->call('setLiveResponder', [service('ux.live_component.live_responder')])
            ->tag('sylius.live_component.admin', ['key' => 'loevgaard_sylius_brand:brand:form'])
    ;
};
