<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

trait BrandAwareFixtureTrait
{
    protected function configureBrandResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $resourceNode
            ->children()
                ->scalarNode('brand')
        ;
    }
}
