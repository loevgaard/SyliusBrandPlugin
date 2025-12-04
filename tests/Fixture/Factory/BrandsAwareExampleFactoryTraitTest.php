<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Fixture\Factory\BrandsAwareExampleFactoryTrait;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandsAwareExampleFactoryTraitTest extends TestCase
{
    use ProphecyTrait;

    #[Test]
    public function it_configures_brands_option(): void
    {
        $brandRepository = $this->prophesize(RepositoryInterface::class);
        $brandRepository->findAll()->willReturn([]);

        $factory = new BrandsAwareExampleFactoryStub($brandRepository->reveal());

        $resolver = new OptionsResolver();
        $factory->exposedConfigureBrandsOptions($resolver);

        $definedOptions = $resolver->getDefinedOptions();

        self::assertContains('brands', $definedOptions);
    }

    #[Test]
    public function it_allows_empty_brands_array(): void
    {
        $brandRepository = $this->prophesize(RepositoryInterface::class);
        $brandRepository->findBy(['code' => []])->willReturn([]);

        $factory = new BrandsAwareExampleFactoryStub($brandRepository->reveal());

        $resolver = new OptionsResolver();
        $factory->exposedConfigureBrandsOptions($resolver);

        $resolved = $resolver->resolve(['brands' => []]);

        self::assertSame([], $resolved['brands']);
    }

    #[Test]
    public function it_sets_random_brand_on_brand_aware_entity(): void
    {
        $brandRepository = $this->prophesize(RepositoryInterface::class);

        $brand1 = $this->prophesize(BrandInterface::class);
        $brand2 = $this->prophesize(BrandInterface::class);

        $brandAware = $this->prophesize(BrandAwareInterface::class);
        // One of the brands should be set
        $brandAware->setBrand($brand1->reveal())->shouldBeCalled();

        $factory = new BrandsAwareExampleFactoryStub($brandRepository->reveal());
        $factory->exposedSetBrandField($brandAware->reveal(), ['brands' => [$brand1->reveal()]]);
    }

    #[Test]
    public function it_initializes_faker(): void
    {
        $brandRepository = $this->prophesize(RepositoryInterface::class);

        $factory = new BrandsAwareExampleFactoryStub($brandRepository->reveal());

        self::assertTrue($factory->hasFaker());
    }
}

/**
 * Stub class that exposes protected methods for testing
 */
class BrandsAwareExampleFactoryStub
{
    use BrandsAwareExampleFactoryTrait;

    public function exposedConfigureBrandsOptions(OptionsResolver $resolver, int $amount = 10): void
    {
        $this->configureBrandsOptions($resolver, $amount);
    }

    public function exposedSetBrandField(BrandAwareInterface $brandAware, array $resolvedOptions = []): void
    {
        $this->setBrandField($brandAware, $resolvedOptions);
    }

    public function hasFaker(): bool
    {
        return isset($this->faker);
    }
}
