<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Doctrine\ORM\BrandRepositoryInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

trait BrandsAwareExampleFactoryTrait
{
    /** @var BrandRepositoryInterface */
    protected $brandRepository;

    /** @var \Faker\Generator */
    protected $faker;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
        if (null === $this->faker) {
            $this->faker = \Faker\Factory::create();
        }
    }

    protected function configureBrandsOptions(OptionsResolver $resolver, int $amount = 10): void
    {
        $resolver
            ->setDefault('brands', LazyOption::randomOnes($this->brandRepository, $amount))
            ->setAllowedTypes('brands', ['array'])
            ->setNormalizer('brands', LazyOption::findBy($this->brandRepository, 'code'))
        ;
    }

    protected function setBrandField(BrandAwareInterface $brandAware, array $resolvedOptions = []): void
    {
        $brand = $this->faker->randomElement($resolvedOptions['brands']);
        Assert::isInstanceOf($brand, BrandInterface::class);

        $brandAware->setBrand($brand);
    }
}
