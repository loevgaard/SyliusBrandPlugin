<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Loevgaard\SyliusBrandPlugin\Model\Brand;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Component\Core\Model\ImageInterface;

class BrandTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function it_has_null_id_by_default(): void
    {
        $brand = new Brand();

        self::assertNull($brand->getId());
    }

    /** @test */
    public function it_has_null_name_by_default(): void
    {
        $brand = new Brand();

        self::assertNull($brand->getName());
    }

    /** @test */
    public function it_has_null_code_by_default(): void
    {
        $brand = new Brand();

        self::assertNull($brand->getCode());
    }

    /** @test */
    public function it_has_empty_images_collection_by_default(): void
    {
        $brand = new Brand();

        self::assertInstanceOf(ArrayCollection::class, $brand->getImages());
        self::assertTrue($brand->getImages()->isEmpty());
    }

    /** @test */
    public function it_allows_setting_name(): void
    {
        $brand = new Brand();
        $brand->setName('Test Brand');

        self::assertSame('Test Brand', $brand->getName());
    }

    /** @test */
    public function it_allows_setting_code(): void
    {
        $brand = new Brand();
        $brand->setCode('test-brand');

        self::assertSame('test-brand', $brand->getCode());
    }

    /** @test */
    public function it_converts_to_string_using_name(): void
    {
        $brand = new Brand();
        $brand->setName('Test Brand');

        self::assertSame('Test Brand', (string) $brand);
    }

    /** @test */
    public function it_converts_to_empty_string_when_name_is_null(): void
    {
        $brand = new Brand();

        self::assertSame('', (string) $brand);
    }

    /** @test */
    public function it_reports_no_images_when_collection_is_empty(): void
    {
        $brand = new Brand();

        self::assertFalse($brand->hasImages());
    }

    /** @test */
    public function it_reports_has_images_when_collection_is_not_empty(): void
    {
        $brand = new Brand();
        $image = $this->prophesize(ImageInterface::class);
        $image->setOwner($brand)->shouldBeCalled();

        $brand->addImage($image->reveal());

        self::assertTrue($brand->hasImages());
    }

    /** @test */
    public function it_adds_image_and_sets_owner(): void
    {
        $brand = new Brand();
        $image = $this->prophesize(ImageInterface::class);
        $image->setOwner($brand)->shouldBeCalledOnce();

        $brand->addImage($image->reveal());

        self::assertTrue($brand->hasImage($image->reveal()));
        self::assertCount(1, $brand->getImages());
    }

    /** @test */
    public function it_does_not_add_same_image_twice(): void
    {
        $brand = new Brand();
        $image = $this->prophesize(ImageInterface::class);
        $image->setOwner($brand)->shouldBeCalledOnce();

        $brand->addImage($image->reveal());
        $brand->addImage($image->reveal());

        self::assertCount(1, $brand->getImages());
    }

    /** @test */
    public function it_removes_image_and_clears_owner(): void
    {
        $brand = new Brand();
        $image = $this->prophesize(ImageInterface::class);
        $image->setOwner($brand)->shouldBeCalled();
        $image->setOwner(null)->shouldBeCalled();

        $brand->addImage($image->reveal());
        $brand->removeImage($image->reveal());

        self::assertFalse($brand->hasImage($image->reveal()));
        self::assertCount(0, $brand->getImages());
    }

    /** @test */
    public function it_does_not_fail_when_removing_non_existing_image(): void
    {
        $brand = new Brand();
        $image = $this->prophesize(ImageInterface::class);

        $brand->removeImage($image->reveal());

        self::assertCount(0, $brand->getImages());
    }

    /** @test */
    public function it_filters_images_by_type(): void
    {
        $brand = new Brand();

        $logoImage = $this->prophesize(ImageInterface::class);
        $logoImage->setOwner($brand)->shouldBeCalled();
        $logoImage->getType()->willReturn('logo');

        $bannerImage = $this->prophesize(ImageInterface::class);
        $bannerImage->setOwner($brand)->shouldBeCalled();
        $bannerImage->getType()->willReturn('banner');

        $anotherLogoImage = $this->prophesize(ImageInterface::class);
        $anotherLogoImage->setOwner($brand)->shouldBeCalled();
        $anotherLogoImage->getType()->willReturn('logo');

        $brand->addImage($logoImage->reveal());
        $brand->addImage($bannerImage->reveal());
        $brand->addImage($anotherLogoImage->reveal());

        $logoImages = $brand->getImagesByType('logo');

        self::assertCount(2, $logoImages);
    }

    /** @test */
    public function it_returns_empty_collection_when_no_images_match_type(): void
    {
        $brand = new Brand();

        $image = $this->prophesize(ImageInterface::class);
        $image->setOwner($brand)->shouldBeCalled();
        $image->getType()->willReturn('banner');

        $brand->addImage($image->reveal());

        $logoImages = $brand->getImagesByType('logo');

        self::assertCount(0, $logoImages);
    }

    /** @test */
    public function it_reports_has_image_correctly(): void
    {
        $brand = new Brand();

        $image1 = $this->prophesize(ImageInterface::class);
        $image1->setOwner($brand)->shouldBeCalled();

        $image2 = $this->prophesize(ImageInterface::class);

        $brand->addImage($image1->reveal());

        self::assertTrue($brand->hasImage($image1->reveal()));
        self::assertFalse($brand->hasImage($image2->reveal()));
    }
}
