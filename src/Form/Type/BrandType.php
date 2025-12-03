<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

final class BrandType extends AbstractResourceType
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventSubscriber(new AddCodeFormSubscriber(null, [
                'label' => 'loevgaard_sylius_brand.form.brand.code',
            ]))
            ->add('name', TextType::class, [
                'label' => 'loevgaard_sylius_brand.form.brand.name',
            ])
            ->add('images', LiveCollectionType::class, [
                'entry_type' => BrandImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'loevgaard_sylius_brand.form.brand.images',
                'block_name' => 'entry',
            ]);
    }

    public function getBlockPrefix(): string
    {
        return 'loevgaard_sylius_brand_brand';
    }
}
