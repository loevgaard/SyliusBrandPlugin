<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class BrandType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'loevgaard_sylius_brand.form.brand.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'loevgaard_sylius_brand.form.brand.slug',
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => BrandImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'loevgaard_sylius_brand.form.brand.images',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'loevgaard_sylius_brand_brand';
    }
}
