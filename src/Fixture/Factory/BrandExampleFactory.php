<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Assigner\ProductsAssignerInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandExampleFactory extends AbstractExampleFactory
{
    protected OptionsResolver $optionsResolver;

    /** @var ProductRepositoryInterface<\Sylius\Component\Core\Model\ProductInterface> */
    protected ProductRepositoryInterface $productRepository;

    protected ProductsAssignerInterface $productAssigner;

    /** @var FactoryInterface<BrandInterface> */
    protected FactoryInterface $brandFactory;

    /** @var FactoryInterface<BrandImageInterface> */
    protected FactoryInterface $productImageFactory;

    protected ImageUploaderInterface $imageUploader;

    protected FileLocatorInterface $fileLocator;

    /**
     * @param ProductRepositoryInterface<\Sylius\Component\Core\Model\ProductInterface> $productRepository
     * @param FactoryInterface<BrandInterface> $brandFactory
     * @param FactoryInterface<BrandImageInterface> $productImageFactory
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductsAssignerInterface $productAssigner,
        FactoryInterface $brandFactory,
        FactoryInterface $productImageFactory,
        ImageUploaderInterface $imageUploader,
        FileLocatorInterface $fileLocator,
    ) {
        $this->productRepository = $productRepository;
        $this->productAssigner = $productAssigner;
        $this->brandFactory = $brandFactory;

        $this->productImageFactory = $productImageFactory;
        $this->imageUploader = $imageUploader;
        $this->fileLocator = $fileLocator;

        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('name')
            ->setAllowedTypes('name', 'string')
            ->setRequired('code')
            ->setAllowedTypes('code', 'string')

            ->setDefault('images', [])
            ->setAllowedTypes('images', 'array')

            ->setDefault('products', [])
            ->setAllowedTypes('products', 'array')
            ->setNormalizer('products', LazyOption::findBy($this->productRepository, 'code'))
        ;
    }

    /** @param array<string, mixed> $options */
    public function create(array $options = []): BrandInterface
    {
        /** @var array{name: string, code: string, images: array<array{path: string, type?: string|null}>, products: list<\Loevgaard\SyliusBrandPlugin\Model\ProductInterface>} $options */
        $options = $this->optionsResolver->resolve($options);

        /** @var BrandInterface $brand */
        $brand = $this->brandFactory->createNew();
        $brand->setName($options['name']);
        $brand->setCode($options['code']);

        $this->createImages($brand, $options);

        $this->productAssigner->assign($brand, $options['products']);

        return $brand;
    }

    /** @param array{images: array<array{path: string, type?: string|null}>} $options */
    protected function createImages(BrandInterface $brand, array $options): void
    {
        foreach ($options['images'] as $image) {
            $imagePath = $image['path'];
            $imageType = $image['type'] ?? null;

            $locatedPath = $this->fileLocator->locate($imagePath, first: true);
            $uploadedImage = new UploadedFile($locatedPath, basename($locatedPath));

            /** @var BrandImageInterface $brandImage */
            $brandImage = $this->productImageFactory->createNew();
            $brandImage->setFile($uploadedImage);
            $brandImage->setType($imageType);

            $this->imageUploader->upload($brandImage);

            $brand->addImage($brandImage);
        }
    }
}
