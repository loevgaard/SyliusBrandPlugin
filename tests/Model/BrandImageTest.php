<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Model;

use Loevgaard\SyliusBrandPlugin\Model\Brand;
use Loevgaard\SyliusBrandPlugin\Model\BrandImage;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class BrandImageTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function it_returns_null_when_no_brand_is_set(): void
    {
        $brandImage = new BrandImage();

        self::assertNull($brandImage->getBrand());
    }

    /** @test */
    public function it_returns_brand_when_owner_is_a_brand(): void
    {
        $brand = new Brand();
        $brandImage = new BrandImage();

        $brandImage->setBrand($brand);

        self::assertSame($brand, $brandImage->getBrand());
    }

    /** @test */
    public function it_sets_brand_as_owner(): void
    {
        $brand = $this->prophesize(BrandInterface::class);
        $brandImage = new BrandImage();

        $brandImage->setBrand($brand->reveal());

        self::assertSame($brand->reveal(), $brandImage->getOwner());
    }

    /** @test */
    public function it_allows_setting_null_brand(): void
    {
        $brand = new Brand();
        $brandImage = new BrandImage();

        $brandImage->setBrand($brand);
        $brandImage->setBrand(null);

        self::assertNull($brandImage->getBrand());
    }
}
