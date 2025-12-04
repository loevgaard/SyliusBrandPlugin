<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Form\Type;

use Loevgaard\SyliusBrandPlugin\Form\Type\BrandImageType;
use Loevgaard\SyliusBrandPlugin\Form\Type\BrandType;
use Loevgaard\SyliusBrandPlugin\Model\Brand;
use Loevgaard\SyliusBrandPlugin\Model\BrandImage;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

class BrandTypeTest extends TypeTestCase
{
    #[Test]
    public function it_has_correct_block_prefix(): void
    {
        $form = $this->factory->create(BrandType::class);

        self::assertSame('loevgaard_sylius_brand_brand', $form->getConfig()->getName());
    }

    #[Test]
    public function it_has_code_field(): void
    {
        $form = $this->factory->create(BrandType::class);

        self::assertTrue($form->has('code'));
    }

    #[Test]
    public function it_has_name_field(): void
    {
        $form = $this->factory->create(BrandType::class);

        self::assertTrue($form->has('name'));
    }

    #[Test]
    public function it_has_images_field(): void
    {
        $form = $this->factory->create(BrandType::class);

        self::assertTrue($form->has('images'));
    }

    #[Test]
    public function it_submits_valid_data(): void
    {
        $brand = new Brand();

        $form = $this->factory->create(BrandType::class, $brand);

        $form->submit([
            'code' => 'test-brand',
            'name' => 'Test Brand',
            'images' => [],
        ]);

        self::assertTrue($form->isSynchronized());
        self::assertSame('test-brand', $brand->getCode());
        self::assertSame('Test Brand', $brand->getName());
    }

    #[Test]
    public function it_submits_data_with_images(): void
    {
        $brand = new Brand();

        $form = $this->factory->create(BrandType::class, $brand);

        $form->submit([
            'code' => 'brand-with-images',
            'name' => 'Brand With Images',
            'images' => [
                ['type' => 'logo'],
                ['type' => 'banner'],
            ],
        ]);

        self::assertTrue($form->isSynchronized());
        self::assertSame('brand-with-images', $brand->getCode());
        self::assertSame('Brand With Images', $brand->getName());
        self::assertCount(2, $brand->getImages());
    }

    #[Test]
    public function it_creates_correct_view(): void
    {
        $form = $this->factory->create(BrandType::class);

        $view = $form->createView();

        self::assertArrayHasKey('code', $view->children);
        self::assertArrayHasKey('name', $view->children);
        self::assertArrayHasKey('images', $view->children);
    }

    #[Test]
    public function it_disables_code_field_for_existing_brand(): void
    {
        $brand = new Brand();
        $brand->setCode('existing-brand');

        $form = $this->factory->create(BrandType::class, $brand);

        $view = $form->createView();

        self::assertTrue($view->children['code']->vars['disabled']);
    }

    #[Test]
    public function it_enables_code_field_for_new_brand(): void
    {
        $brand = new Brand();

        $form = $this->factory->create(BrandType::class, $brand);

        $view = $form->createView();

        self::assertFalse($view->children['code']->vars['disabled']);
    }

    protected function getTypes(): array
    {
        return [
            new BrandType(Brand::class, ['loevgaard_sylius_brand']),
            new BrandImageType(BrandImage::class, ['loevgaard_sylius_brand']),
            new LiveCollectionType(),
        ];
    }
}
