<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class BrandContext implements Context
{
    /**
     * @var RepositoryInterface
     */
    private $brandRepository;

    /**
     * @var FactoryInterface
     */
    private $brandFactory;

    public function __construct(RepositoryInterface $brandRepository, FactoryInterface $brandFactory)
    {
        $this->brandRepository = $brandRepository;
        $this->brandFactory = $brandFactory;
    }

    /**
     * @Given the store has a brand :brandName
     */
    public function storeHasABrand($brandName)
    {
        $brand = $this->createBrand($brandName);

        $this->saveBrand($brand);
    }

    private function createBrand(string $name): BrandInterface
    {
        /** @var BrandInterface $brand */
        $brand = $this->brandFactory->createNew();

        $brand->setName($name);
        $brand->setSlug(strtolower($name));

        return $brand;
    }

    private function saveBrand(BrandInterface $brand): void
    {
        $this->brandRepository->add($brand);
    }
}
