<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Extension;

use Loevgaard\SyliusBrandPlugin\Form\Type\BrandChoiceType;
use Sylius\Bundle\AdminApiBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class ApiProductTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('brand', BrandChoiceType::class, [
            'placeholder' => 'loevgaard_sylius_brand.form.product.select_brand',
            'label' => 'loevgaard_sylius_brand.form.product.brand',
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes()
    {
        return [
            ProductType::class,
        ];
    }
}
