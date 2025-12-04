<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

trait BrandAwareExampleFactoryTrait
{
    /**
     * @param RepositoryInterface<BrandInterface> $brandRepository
     */
    public function __construct(protected readonly RepositoryInterface $brandRepository)
    {
    }

    protected function configureBrandOptions(OptionsResolver $resolver, int $chanceOfRandomBrand = 90): void
    {
        $resolver
            ->setDefault('brand', LazyOption::randomOneOrNull($this->brandRepository, $chanceOfRandomBrand))
            ->setAllowedTypes('brand', ['null', 'string', BrandInterface::class])
            ->setNormalizer('brand', LazyOption::findOneBy($this->brandRepository, 'code'))
        ;
    }

    /** @param array{brand?: BrandInterface|null} $resolvedOptions */
    protected function setBrandField(BrandAwareInterface $brandAware, array $resolvedOptions = []): void
    {
        $brandAware->setBrand($resolvedOptions['brand'] ?? null);
    }
}
