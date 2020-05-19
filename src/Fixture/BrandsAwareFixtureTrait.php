<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

trait BrandsAwareFixtureTrait
{
    protected function configureBrandsResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $resourceNode
            ->children()
                ->arrayNode('brands')->scalarPrototype()
        ;
    }
}
