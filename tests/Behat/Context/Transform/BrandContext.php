<?php

/** @noinspection PhpDocSignatureInspection */

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Loevgaard\SyliusBrandPlugin\Doctrine\ORM\BrandRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class BrandContext implements Context
{
    /**
     * @var BrandRepositoryInterface
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
        /** @noinspection PhpUndefinedMethodInspection */
        $brands = $this->brandRepository->findByName($brandName);

        Assert::eq(
            count($brands),
            1,
            sprintf('%d brands has been found with name "%s".', count($brands), $brandName)
        );

        return $brands[0];
    }
}
