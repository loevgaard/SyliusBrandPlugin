<?php

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
        $node = $resourceNode->children();
        $node->scalarNode('name')->cannotBeEmpty();
        $node->scalarNode('code')->cannotBeEmpty();
        $node->arrayNode('images')->variablePrototype();
        $node->arrayNode('products')->scalarPrototype();
    }
}
