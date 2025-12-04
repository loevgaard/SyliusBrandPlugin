<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Fixture;

use Doctrine\Persistence\ObjectManager;
use Loevgaard\SyliusBrandPlugin\Fixture\BrandsAwareFixtureTrait;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Bundle\CoreBundle\Fixture\AbstractResourceFixture;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class BrandsAwareFixtureTraitTest extends TestCase
{
    use ConfigurationTestCaseTrait;
    use ProphecyTrait;

    #[Test]
    public function it_configures_brands_node(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    ['brands' => ['brand-1', 'brand-2']],
                ],
            ],
        ], 'custom.*.brands');
    }

    #[Test]
    public function it_allows_single_brand(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    ['brands' => ['single-brand']],
                ],
            ],
        ], 'custom.*.brands');
    }

    #[Test]
    public function it_allows_empty_brands_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    ['brands' => []],
                ],
            ],
        ], 'custom.*.brands');
    }

    #[Test]
    public function it_allows_missing_brands(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    [],
                ],
            ],
        ], 'custom');
    }

    protected function getConfiguration(): BrandsAwareFixtureStub
    {
        return new BrandsAwareFixtureStub(
            $this->prophesize(ObjectManager::class)->reveal(),
            $this->prophesize(ExampleFactoryInterface::class)->reveal(),
        );
    }
}

/**
 * Stub fixture class that uses BrandsAwareFixtureTrait for testing
 */
class BrandsAwareFixtureStub extends AbstractResourceFixture
{
    use BrandsAwareFixtureTrait;

    public function getName(): string
    {
        return 'brands_aware_fixture_stub';
    }

    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $this->configureBrandsResourceNode($resourceNode);
    }
}
