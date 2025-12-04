<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Loevgaard\SyliusBrandPlugin\Form\Extension\ProductTypeExtension;
use Loevgaard\SyliusBrandPlugin\Form\Type\BrandAutocompleteChoiceType;
use Loevgaard\SyliusBrandPlugin\Form\Type\BrandImageType;
use Loevgaard\SyliusBrandPlugin\Form\Type\BrandType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;

return static function (ContainerConfigurator $container): void {
    $container->parameters()
        ->set('loevgaard_sylius_brand.form.type.brand.validation_groups', ['loevgaard_sylius_brand'])
        ->set('loevgaard_sylius_brand.form.type.brand_image.validation_groups', ['loevgaard_sylius_brand'])
    ;

    $container->services()
        ->set(ProductTypeExtension::class)
            ->args([
                param('loevgaard_sylius_brand.model.brand.class'),
            ])
            ->tag('form.type_extension', ['extended_type' => ProductType::class])

        ->set(BrandAutocompleteChoiceType::class)
            ->args([
                param('loevgaard_sylius_brand.model.brand.class'),
            ])
            ->tag('form.type')
            ->tag('ux.entity_autocomplete_field')

        ->set(BrandType::class)
            ->args([
                param('loevgaard_sylius_brand.model.brand.class'),
                param('loevgaard_sylius_brand.form.type.brand.validation_groups'),
            ])
            ->tag('form.type')

        ->set(BrandImageType::class)
            ->args([
                param('loevgaard_sylius_brand.model.brand_image.class'),
                param('loevgaard_sylius_brand.form.type.brand_image.validation_groups'),
            ])
            ->tag('form.type')
    ;
};
