<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Assigner\ProductsAssignerInterface;
use Loevgaard\SyliusBrandPlugin\Entity\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

    /** @var FactoryInterface */
    protected $productImageFactory;

    /** @var ImageUploaderInterface */
    private $imageUploader;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param ProductsAssignerInterface $productAssigner
     * @param FactoryInterface $brandFactory
     * @param FactoryInterface $productImageFactory
     * @param ImageUploaderInterface $imageUploader
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductsAssignerInterface $productAssigner,
        FactoryInterface $brandFactory,
        FactoryInterface $productImageFactory,
        ImageUploaderInterface $imageUploader
    ) {
        $this->productRepository = $productRepository;
        $this->productAssigner = $productAssigner;
        $this->brandFactory = $brandFactory;

        $this->productImageFactory = $productImageFactory;
        $this->imageUploader = $imageUploader;

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

            ->setDefault('images', [])
            ->setAllowedTypes('images', 'array')

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

        $this->createImages($brand, $options);

        $this->productAssigner->assign($brand, $options['products']);

        return $brand;
    }

    /**
     * @param BrandInterface $brand
     * @param array $options
     */
    private function createImages(BrandInterface $brand, array $options): void
    {
        foreach ($options['images'] as $image) {
            $imagePath = $image['path'];
            $imageType = $image['type'] ?? null;

            $uploadedImage = new UploadedFile($imagePath, basename($imagePath));

            /** @var BrandImageInterface $brandImage */
            $brandImage = $this->productImageFactory->createNew();
            $brandImage->setFile($uploadedImage);
            $brandImage->setType($imageType);

            $this->imageUploader->upload($brandImage);

            $brand->addImage($brandImage);
        }
    }
}
