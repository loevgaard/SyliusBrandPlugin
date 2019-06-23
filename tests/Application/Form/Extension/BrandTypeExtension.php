<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Form\Extension;

use Loevgaard\SyliusBrandPlugin\Form\Type\BrandType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BrandTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('description', TextType::class, [
            'label' => 'app.form.brand.description',
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes()
    {
        return [
            BrandType::class,
        ];
    }
}
