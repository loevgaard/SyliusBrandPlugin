<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Grid\Mutator;

use Loevgaard\SyliusBrandPlugin\Grid\Mutator\AdminProductGridMutator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Grid\Builder\GridBuilder;

final class AdminProductGridMutatorTest extends TestCase
{
    #[Test]
    public function it_adds_the_brand_field_and_filter_to_the_admin_product_grid(): void
    {
        $gridBuilder = GridBuilder::create('sylius_admin_product');

        (new AdminProductGridMutator('App\\Entity\\Brand'))($gridBuilder);

        $grid = $gridBuilder->toArray();
        $fields = $grid['fields'] ?? null;
        $filters = $grid['filters'] ?? null;
        self::assertIsArray($fields);
        self::assertIsArray($filters);

        self::assertSame([
            'type' => 'twig',
            'label' => 'loevgaard_sylius_brand.ui.brand',
            'options' => [
                'template' => '@LoevgaardSyliusBrandPlugin/grid/field/brand.html.twig',
            ],
        ], $fields['brand'] ?? null);
        self::assertSame([
            'type' => 'entity',
            'label' => 'loevgaard_sylius_brand.ui.brand',
            'form_options' => [
                'class' => 'App\\Entity\\Brand',
            ],
        ], $filters['brand'] ?? null);
    }
}
