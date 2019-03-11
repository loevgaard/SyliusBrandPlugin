<?php

/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class BrandFixture extends AbstractResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'loevgaard_sylius_brand_plugin_brand';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $resourceNode
            ->children()
                ->scalarNode('name')->cannotBeEmpty()->end()
                ->scalarNode('code')->cannotBeEmpty()->end()
                ->arrayNode('images')->variablePrototype()->end()->end()
                ->arrayNode('products')->scalarPrototype()->end()->end()
        ;
    }
}
