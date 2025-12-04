<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Fixture;

use Doctrine\Persistence\ObjectManager;
use Loevgaard\SyliusBrandPlugin\Fixture\BrandAwareFixtureTrait;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Bundle\CoreBundle\Fixture\AbstractResourceFixture;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class BrandAwareFixtureTraitTest extends TestCase
{
    use ConfigurationTestCaseTrait;
    use ProphecyTrait;

    /** @test */
    public function it_configures_brand_node(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    ['brand' => 'test-brand'],
                ],
            ],
        ], 'custom.*.brand');
    }

    /** @test */
    public function it_allows_null_brand(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    ['brand' => null],
                ],
            ],
        ], 'custom.*.brand');
    }

    /** @test */
    public function it_allows_missing_brand(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    [],
                ],
            ],
        ], 'custom');
    }

    protected function getConfiguration(): BrandAwareFixtureStub
    {
        return new BrandAwareFixtureStub(
            $this->prophesize(ObjectManager::class)->reveal(),
            $this->prophesize(ExampleFactoryInterface::class)->reveal(),
        );
    }
}

/**
 * Stub fixture class that uses BrandAwareFixtureTrait for testing
 */
class BrandAwareFixtureStub extends AbstractResourceFixture
{
    use BrandAwareFixtureTrait;

    public function getName(): string
    {
        return 'brand_aware_fixture_stub';
    }

    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $this->configureBrandResourceNode($resourceNode);
    }
}
