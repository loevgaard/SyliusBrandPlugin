<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Factory;

use Loevgaard\SyliusBrandPlugin\Factory\BrandImageFactory;
use Loevgaard\SyliusBrandPlugin\Model\BrandImage;
use Loevgaard\SyliusBrandPlugin\Model\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Component\Resource\Factory\FactoryInterface;

class BrandImageFactoryTest extends TestCase
{
    use ProphecyTrait;

    #[Test]
    public function it_creates_new_brand_image(): void
    {
        $brandImage = new BrandImage();

        $innerFactory = $this->prophesize(FactoryInterface::class);
        $innerFactory->createNew()->willReturn($brandImage);

        $factory = new BrandImageFactory($innerFactory->reveal());

        $result = $factory->createNew();

        self::assertSame($brandImage, $result);
    }

    #[Test]
    public function it_creates_brand_image_for_brand(): void
    {
        $brand = $this->prophesize(BrandInterface::class);
        $brandImage = $this->prophesize(BrandImageInterface::class);

        $brandImage->setBrand($brand->reveal())->shouldBeCalledOnce();

        $innerFactory = $this->prophesize(FactoryInterface::class);
        $innerFactory->createNew()->willReturn($brandImage->reveal());

        $factory = new BrandImageFactory($innerFactory->reveal());

        $result = $factory->createForBrand($brand->reveal());

        self::assertSame($brandImage->reveal(), $result);
    }
}
