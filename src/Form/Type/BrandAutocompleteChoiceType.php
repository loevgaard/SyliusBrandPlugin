<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BrandAutocompleteChoiceType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'resource' => 'loevgaard_sylius_brand.brand',
            'choice_name' => 'name',
            'choice_value' => 'code',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['remote_criteria_type'] = 'contains';
        $view->vars['remote_criteria_name'] = 'phrase';
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix(): string
    {
        return 'loevgaard_sylius_brand_autocomplete_choice';
    }

    /**
     * @inheritdoc
     */
    public function getParent(): string
    {
        return ResourceAutocompleteChoiceType::class;
    }
}
