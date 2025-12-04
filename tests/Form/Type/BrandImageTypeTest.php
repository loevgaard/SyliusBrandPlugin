<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Form\Type;

use Loevgaard\SyliusBrandPlugin\Form\Type\BrandImageType;
use Loevgaard\SyliusBrandPlugin\Model\BrandImage;
use Symfony\Component\Form\Test\TypeTestCase;

class BrandImageTypeTest extends TypeTestCase
{
    /** @test */
    public function it_has_correct_block_prefix(): void
    {
        $form = $this->factory->create(BrandImageType::class);

        self::assertSame('loevgaard_sylius_brand_brand_image', $form->getConfig()->getName());
    }

    /** @test */
    public function it_has_type_field(): void
    {
        $form = $this->factory->create(BrandImageType::class);

        self::assertTrue($form->has('type'));
    }

    /** @test */
    public function it_has_file_field(): void
    {
        $form = $this->factory->create(BrandImageType::class);

        self::assertTrue($form->has('file'));
    }

    /** @test */
    public function it_submits_valid_data(): void
    {
        $brandImage = new BrandImage();

        $form = $this->factory->create(BrandImageType::class, $brandImage);

        $form->submit([
            'type' => 'logo',
        ]);

        self::assertTrue($form->isSynchronized());
        self::assertSame('logo', $brandImage->getType());
    }

    /** @test */
    public function it_allows_null_type(): void
    {
        $brandImage = new BrandImage();

        $form = $this->factory->create(BrandImageType::class, $brandImage);

        $form->submit([
            'type' => null,
        ]);

        self::assertTrue($form->isSynchronized());
        self::assertNull($brandImage->getType());
    }

    /** @test */
    public function it_creates_correct_view(): void
    {
        $form = $this->factory->create(BrandImageType::class);

        $view = $form->createView();

        self::assertArrayHasKey('type', $view->children);
        self::assertArrayHasKey('file', $view->children);
    }

    protected function getTypes(): array
    {
        return [
            new BrandImageType(BrandImage::class, ['loevgaard_sylius_brand']),
        ];
    }
}
