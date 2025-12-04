<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Fixture\Factory\BrandAwareExampleFactoryTrait;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandAwareExampleFactoryTraitTest extends TestCase
{
    use ProphecyTrait;

    #[Test]
    public function it_configures_brand_option_with_allowed_types(): void
    {
        $brandRepository = $this->prophesize(RepositoryInterface::class);
        $brandRepository->findAll()->willReturn([]);

        $factory = new BrandAwareExampleFactoryStub($brandRepository->reveal());

        $resolver = new OptionsResolver();
        $factory->exposedConfigureBrandOptions($resolver);

        $definedOptions = $resolver->getDefinedOptions();

        self::assertContains('brand', $definedOptions);
    }

    #[Test]
    public function it_allows_null_brand(): void
    {
        $brandRepository = $this->prophesize(RepositoryInterface::class);
        $brandRepository->findOneBy(['code' => null])->willReturn(null);

        $factory = new BrandAwareExampleFactoryStub($brandRepository->reveal());

        $resolver = new OptionsResolver();
        $factory->exposedConfigureBrandOptions($resolver);

        $resolved = $resolver->resolve(['brand' => null]);

        self::assertNull($resolved['brand']);
    }

    #[Test]
    public function it_sets_brand_on_brand_aware_entity(): void
    {
        $brandRepository = $this->prophesize(RepositoryInterface::class);
        $brand = $this->prophesize(BrandInterface::class);

        $brandAware = $this->prophesize(BrandAwareInterface::class);
        $brandAware->setBrand($brand->reveal())->shouldBeCalledOnce();

        $factory = new BrandAwareExampleFactoryStub($brandRepository->reveal());
        $factory->exposedSetBrandField($brandAware->reveal(), ['brand' => $brand->reveal()]);
    }

    #[Test]
    public function it_sets_null_brand_when_not_provided(): void
    {
        $brandRepository = $this->prophesize(RepositoryInterface::class);

        $brandAware = $this->prophesize(BrandAwareInterface::class);
        $brandAware->setBrand(null)->shouldBeCalledOnce();

        $factory = new BrandAwareExampleFactoryStub($brandRepository->reveal());
        $factory->exposedSetBrandField($brandAware->reveal(), []);
    }
}

/**
 * Stub class that exposes protected methods for testing
 */
class BrandAwareExampleFactoryStub
{
    use BrandAwareExampleFactoryTrait;

    public function exposedConfigureBrandOptions(OptionsResolver $resolver, int $chanceOfRandomBrand = 90): void
    {
        $this->configureBrandOptions($resolver, $chanceOfRandomBrand);
    }

    public function exposedSetBrandField(BrandAwareInterface $brandAware, array $resolvedOptions = []): void
    {
        $this->setBrandField($brandAware, $resolvedOptions);
    }
}
