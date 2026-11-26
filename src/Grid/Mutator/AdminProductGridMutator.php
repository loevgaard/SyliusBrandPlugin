<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Grid\Mutator;

use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\EntityFilter;
use Sylius\Component\Grid\Builder\GridBuilderInterface;
use Sylius\Component\Grid\Mutator\GridMutatorInterface;

final class AdminProductGridMutator implements GridMutatorInterface
{
    public function __construct(private readonly string $brandClass)
    {
    }

    public function __invoke(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->addField(
                TwigField::create('brand', '@LoevgaardSyliusBrandPlugin/grid/field/brand.html.twig')
                    ->setLabel('loevgaard_sylius_brand.ui.brand'),
            )
            ->addFilter(
                EntityFilter::create('brand', $this->brandClass)
                    ->setLabel('loevgaard_sylius_brand.ui.brand'),
            )
        ;
    }
}
