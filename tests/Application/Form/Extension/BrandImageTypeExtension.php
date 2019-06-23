<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Form\Extension;

use Loevgaard\SyliusBrandPlugin\Form\Type\BrandImageType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BrandImageTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('alt', TextType::class, [
            'label' => 'app.form.brand_image.alt',
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes()
    {
        return [
            BrandImageType::class,
        ];
    }
}
