<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Loevgaard\SyliusBrandPlugin\Fixture\BrandFixture;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;

class BrandFixtureTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    /** @test */
    public function brand_are_optional(): void
    {
        $this->assertConfigurationIsValid([[]], 'custom');
    }

    /** @test */
    public function brand_can_be_generated_randomly(): void
    {
        $this->assertConfigurationIsValid([['random' => 4]], 'random');
        $this->assertPartialConfigurationIsInvalid([['random' => -1]], 'random');
    }

    /** @test */
    public function brand_products_is_optional(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['products' => []]]]], 'custom.*.products');
    }

    protected function getConfiguration(): BrandFixture
    {
        return new BrandFixture(
            $this->getMockBuilder(ObjectManager::class)->getMock(),
            $this->getMockBuilder(ExampleFactoryInterface::class)->getMock(),
        );
    }
}
