<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Assigner\ProductsAssignerInterface;
use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BrandExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var OptionsResolver */
    private $optionsResolver;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ProductsAssignerInterface */
    private $productAssigner;

    /** @var FactoryInterface */
    protected $brandFactory;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param ProductsAssignerInterface $productAssigner
     * @param FactoryInterface $brandFactory
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductsAssignerInterface $productAssigner,
        FactoryInterface $brandFactory)
    {
        $this->productRepository = $productRepository;
        $this->productAssigner = $productAssigner;
        $this->brandFactory = $brandFactory;

        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }


    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('name')
            ->setAllowedTypes('name', 'string')
            ->setRequired('slug')
            ->setAllowedTypes('slug', 'string')
            ->setDefault('products', [])
            ->setAllowedTypes('products', 'array')
            ->setNormalizer('products', LazyOption::findBy($this->productRepository, 'code'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): BrandInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var BrandInterface $brand */
        $brand = $this->brandFactory->createNew();
        $brand->setName($options['name']);
        $brand->setSlug($options['slug']);

        $this->productAssigner->assign($brand, $options['products']);

        return $brand;
    }
}
