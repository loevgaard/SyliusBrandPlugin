<?php

/** @noinspection PhpUnusedLocalVariableInspection */

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('loevgaard_sylius_brand');

        return $treeBuilder;
    }
}
