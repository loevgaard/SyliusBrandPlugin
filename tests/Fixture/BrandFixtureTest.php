<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Fixture;

use Doctrine\Persistence\ObjectManager;
use Loevgaard\SyliusBrandPlugin\Fixture\BrandFixture;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;

class BrandFixtureTest extends TestCase
{
    use ConfigurationTestCaseTrait;
    use ProphecyTrait;

    /** @test */
    public function it_returns_correct_fixture_name(): void
    {
        $fixture = $this->getConfiguration();

        self::assertSame('loevgaard_sylius_brand_plugin_brand', $fixture->getName());
    }

    /** @test */
    public function it_allows_empty_custom_brands(): void
    {
        $this->assertConfigurationIsValid([[]], 'custom');
    }

    /** @test */
    public function it_allows_random_brand_generation(): void
    {
        $this->assertConfigurationIsValid([['random' => 4]], 'random');
    }

    /** @test */
    public function it_rejects_negative_random_count(): void
    {
        $this->assertPartialConfigurationIsInvalid([['random' => -1]], 'random');
    }

    /** @test */
    public function it_allows_brand_with_name_and_code(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    [
                        'name' => 'Test Brand',
                        'code' => 'test-brand',
                    ],
                ],
            ],
        ], 'custom');
    }

    /** @test */
    public function it_rejects_empty_name(): void
    {
        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    [
                        'name' => '',
                        'code' => 'test-brand',
                    ],
                ],
            ],
        ], 'custom.*.name');
    }

    /** @test */
    public function it_rejects_empty_code(): void
    {
        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    [
                        'name' => 'Test Brand',
                        'code' => '',
                    ],
                ],
            ],
        ], 'custom.*.code');
    }

    /** @test */
    public function it_allows_products_configuration(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    [
                        'products' => ['product-1', 'product-2'],
                    ],
                ],
            ],
        ], 'custom.*.products');
    }

    /** @test */
    public function it_allows_empty_products(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['products' => []]]]], 'custom.*.products');
    }

    /** @test */
    public function it_allows_images_configuration(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    [
                        'images' => [
                            ['path' => '/path/to/image.jpg', 'type' => 'logo'],
                            ['path' => '/path/to/another.png'],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.images');
    }

    /** @test */
    public function it_allows_empty_images(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['images' => []]]]], 'custom.*.images');
    }

    protected function getConfiguration(): BrandFixture
    {
        return new BrandFixture(
            $this->prophesize(ObjectManager::class)->reveal(),
            $this->prophesize(ExampleFactoryInterface::class)->reveal(),
        );
    }
}
