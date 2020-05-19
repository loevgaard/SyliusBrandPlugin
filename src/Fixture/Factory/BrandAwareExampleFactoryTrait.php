<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Doctrine\ORM\BrandRepositoryInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Symfony\Component\OptionsResolver\OptionsResolver;

trait BrandAwareExampleFactoryTrait
{
    /** @var BrandRepositoryInterface */
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    protected function configureBrandOptions(OptionsResolver $resolver, int $chanceOfRandomBrand = 90): void
    {
        $resolver
            ->setDefault('brand', LazyOption::randomOneOrNull($this->brandRepository, $chanceOfRandomBrand))
            ->setAllowedTypes('brand', ['null', 'string', BrandInterface::class])
            ->setNormalizer('brand', LazyOption::findOneBy($this->brandRepository, 'code'))
        ;
    }

    protected function setBrandField(BrandAwareInterface $brandAware, array $resolvedOptions = []): void
    {
        $brandAware->setBrand($resolvedOptions['brand']);
    }
}
