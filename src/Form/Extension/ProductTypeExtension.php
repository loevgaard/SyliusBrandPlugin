<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Extension;

use Loevgaard\SyliusBrandPlugin\Form\Type\BrandChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('brand', BrandChoiceType::class, [
            'multiple' => false,
            'expanded' => false,
            'label' => 'loevgaard_sylius_brand.form.product.select_brand',
        ]);
    }

    public function getExtendedType(): string
    {
        return ProductType::class;
    }
}
