<?php

/** @noinspection PhpUnusedParameterInspection */

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Type;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BrandChoiceType extends AbstractType
{
    /**
     * @var RepositoryInterface
     */
    private $brandRepository;

    /**
     * @param RepositoryInterface $brandRepository
     */
    public function __construct(RepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['multiple']) {
            $builder->addModelTransformer(new CollectionToArrayTransformer());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => function (Options $options) {
                return $this->brandRepository->findAll();
            },
            'choice_value' => 'slug',
            'choice_label' => 'name',
            'choice_translation_domain' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'loevgaard_sylius_brand_choice';
    }
}
