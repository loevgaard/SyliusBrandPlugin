<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture\Factory;

use Faker\Factory;
use Faker\Generator;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

trait BrandsAwareExampleFactoryTrait
{
    protected Generator $faker;

    /**
     * @param RepositoryInterface<BrandInterface> $brandRepository
     */
    public function __construct(protected readonly RepositoryInterface $brandRepository)
    {
        $this->faker = Factory::create();
    }

    protected function configureBrandsOptions(OptionsResolver $resolver, int $amount = 10): void
    {
        $resolver
            ->setDefault('brands', LazyOption::randomOnes($this->brandRepository, $amount))
            ->setAllowedTypes('brands', ['array'])
            ->setNormalizer('brands', LazyOption::findBy($this->brandRepository, 'code'))
        ;
    }

    /** @param array{brands: list<BrandInterface>} $resolvedOptions */
    protected function setBrandField(BrandAwareInterface $brandAware, array $resolvedOptions): void
    {
        $brand = $this->faker->randomElement($resolvedOptions['brands']);
        Assert::isInstanceOf($brand, BrandInterface::class);

        $brandAware->setBrand($brand);
    }
}
