<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Fixture\Factory;

use Loevgaard\SyliusBrandPlugin\Fixture\Factory\BrandExampleFactory;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Config\FileLocatorInterface;

class BrandExampleFactoryTest extends TestCase
{
    use ProphecyTrait;

    #[Test]
    public function it_creates_brand_with_name_and_code(): void
    {
        $brand = $this->prophesize(BrandInterface::class);
        $brand->setName('Test Brand')->shouldBeCalledOnce();
        $brand->setCode('test-brand')->shouldBeCalledOnce();

        $brandFactory = $this->prophesize(FactoryInterface::class);
        $brandFactory->createNew()->willReturn($brand->reveal());

        $factory = new BrandExampleFactory(
            $this->prophesize(ProductRepositoryInterface::class)->reveal(),
            $brandFactory->reveal(),
            $this->prophesize(FactoryInterface::class)->reveal(),
            $this->prophesize(ImageUploaderInterface::class)->reveal(),
            $this->prophesize(FileLocatorInterface::class)->reveal(),
        );

        $result = $factory->create([
            'name' => 'Test Brand',
            'code' => 'test-brand',
        ]);

        self::assertSame($brand->reveal(), $result);
    }

    #[Test]
    public function it_associates_products_with_brand(): void
    {
        $brand = $this->prophesize(BrandInterface::class);
        $brand->setName('Test Brand')->shouldBeCalled();
        $brand->setCode('test-brand')->shouldBeCalled();

        $product1 = $this->prophesize(BrandAwareInterface::class);
        $product1->setBrand($brand->reveal())->shouldBeCalledOnce();

        $product2 = $this->prophesize(BrandAwareInterface::class);
        $product2->setBrand($brand->reveal())->shouldBeCalledOnce();

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productRepository->findOneBy(['code' => 'product-1'])->willReturn($product1->reveal());
        $productRepository->findOneBy(['code' => 'product-2'])->willReturn($product2->reveal());

        $brandFactory = $this->prophesize(FactoryInterface::class);
        $brandFactory->createNew()->willReturn($brand->reveal());

        $factory = new BrandExampleFactory(
            $productRepository->reveal(),
            $brandFactory->reveal(),
            $this->prophesize(FactoryInterface::class)->reveal(),
            $this->prophesize(ImageUploaderInterface::class)->reveal(),
            $this->prophesize(FileLocatorInterface::class)->reveal(),
        );

        $factory->create([
            'name' => 'Test Brand',
            'code' => 'test-brand',
            'products' => ['product-1', 'product-2'],
        ]);
    }

    #[Test]
    public function it_throws_exception_when_name_is_missing(): void
    {
        $factory = new BrandExampleFactory(
            $this->prophesize(ProductRepositoryInterface::class)->reveal(),
            $this->prophesize(FactoryInterface::class)->reveal(),
            $this->prophesize(FactoryInterface::class)->reveal(),
            $this->prophesize(ImageUploaderInterface::class)->reveal(),
            $this->prophesize(FileLocatorInterface::class)->reveal(),
        );

        $this->expectException(\Symfony\Component\OptionsResolver\Exception\MissingOptionsException::class);
        $factory->create(['code' => 'test']);
    }

    #[Test]
    public function it_throws_exception_when_code_is_missing(): void
    {
        $factory = new BrandExampleFactory(
            $this->prophesize(ProductRepositoryInterface::class)->reveal(),
            $this->prophesize(FactoryInterface::class)->reveal(),
            $this->prophesize(FactoryInterface::class)->reveal(),
            $this->prophesize(ImageUploaderInterface::class)->reveal(),
            $this->prophesize(FileLocatorInterface::class)->reveal(),
        );

        $this->expectException(\Symfony\Component\OptionsResolver\Exception\MissingOptionsException::class);
        $factory->create(['name' => 'Test']);
    }
}
