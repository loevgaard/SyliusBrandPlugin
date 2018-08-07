<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class BrandContext implements Context
{
    /**
     * @var RepositoryInterface
     */
    private $brandRepository;

    public function __construct(RepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @Transform :brand
     */
    public function getBrandByName($brandName)
    {
        $brands = $this->brandRepository->findByName($brandName);

        Assert::eq(
            count($brands),
            1,
            sprintf('%d brands has been found with name "%s".', count($brands), $brandName)
        );

        return $brands[0];
    }
}
