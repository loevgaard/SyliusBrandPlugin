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
    /** @var OptionsResolver */
    protected $optionsResolver;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var ProductsAssignerInterface */
    protected $productAssigner;

    /** @var FactoryInterface */
    protected $brandFactory;

    /** @var FactoryInterface */
    protected $productImageFactory;

    /** @var ImageUploaderInterface */
    protected $imageUploader;

    /** @var FileLocatorInterface */
    protected $fileLocator;

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

    public function create(array $options = []): BrandInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var BrandInterface $brand */
        $brand = $this->brandFactory->createNew();
        $brand->setName($options['name']);
        $brand->setCode($options['code']);

        $this->createImages($brand, $options);

        $this->productAssigner->assign($brand, $options['products']);

        return $brand;
    }

    protected function createImages(BrandInterface $brand, array $options): void
    {
        foreach ($options['images'] as $image) {
            $imagePath = $image['path'];
            $imageType = $image['type'] ?? null;

            $imagePath = $this->fileLocator->locate($imagePath);
            if (is_array($imagePath)) {
                $imagePath = $imagePath[array_key_first($imagePath)];
            }
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
