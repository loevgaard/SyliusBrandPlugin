<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Application\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Fixture\Factory\BrandExampleFactory as BaseBrandExampleFactory;
use Loevgaard\SyliusBrandPlugin\Model\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tests\Loevgaard\SyliusBrandPlugin\Application\Model\Brand;
use Tests\Loevgaard\SyliusBrandPlugin\Application\Model\BrandImage;

class BrandExampleFactory extends BaseBrandExampleFactory
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefined('description')
            ->setAllowedTypes('description', ['null', 'string'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): BrandInterface
    {
        /** @var Brand $brand */
        $brand = parent::create($options);

        $options = $this->optionsResolver->resolve($options);
        if (isset($options['description'])) {
            $brand->setDescription($options['description']);
        }

        return $brand;
    }

    /**
     * {@inheritdoc}
     */
    protected function createImages(BrandInterface $brand, array $options): void
    {
        foreach ($options['images'] as $image) {
            $imagePath = $image['path'];

            $uploadedImage = new UploadedFile($imagePath, basename($imagePath));

            /** @var BrandImage $brandImage */
            $brandImage = $this->productImageFactory->createNew();
            $brandImage->setFile($uploadedImage);
            $brandImage->setType($image['type'] ?? null);
            $brandImage->setAlt($image['alt'] ?? null);

            $this->imageUploader->upload($brandImage);

            $brand->addImage($brandImage);
        }
    }
}
