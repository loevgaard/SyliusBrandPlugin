<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Fixture;

use Loevgaard\SyliusBrandPlugin\Fixture\BrandFixture as BaseBrandFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class BrandFixture extends BaseBrandFixture
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app_brand';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        parent::configureResourceNode($resourceNode);

        $node = $resourceNode->children();
        $node->scalarNode('description')->defaultNull();
    }
}
