<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\DependencyInjection;

use Loevgaard\SyliusBrandPlugin\DependencyInjection\LoevgaardSyliusBrandExtension;
use Loevgaard\SyliusBrandPlugin\EventSubscriber\AdminMenuSubscriber;
use Loevgaard\SyliusBrandPlugin\EventSubscriber\BrandDeletionSubscriber;
use Loevgaard\SyliusBrandPlugin\EventSubscriber\ImageUploadSubscriber;
use Loevgaard\SyliusBrandPlugin\Factory\BrandImageFactory;
use Loevgaard\SyliusBrandPlugin\Fixture\BrandFixture;
use Loevgaard\SyliusBrandPlugin\Fixture\Factory\BrandExampleFactory;
use Loevgaard\SyliusBrandPlugin\Form\Extension\ProductTypeExtension;
use Loevgaard\SyliusBrandPlugin\Form\Type\BrandAutocompleteChoiceType;
use Loevgaard\SyliusBrandPlugin\Form\Type\BrandImageType;
use Loevgaard\SyliusBrandPlugin\Form\Type\BrandType;
use Loevgaard\SyliusBrandPlugin\Model\Brand;
use Loevgaard\SyliusBrandPlugin\Model\BrandImage;
use Loevgaard\SyliusBrandPlugin\Twig\Component\Brand\FormComponent;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use PHPUnit\Framework\Attributes\Test;
use Sylius\Bundle\CoreBundle\EventListener\ImagesUploadListener;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;

class LoevgaardSyliusBrandExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new LoevgaardSyliusBrandExtension(),
        ];
    }

    /** @return array<string, mixed> */
    protected function getMinimalConfiguration(): array
    {
        return [
            'resources' => [
                'brand' => [
                    'classes' => [
                        'model' => Brand::class,
                    ],
                ],
                'brand_image' => [
                    'classes' => [
                        'model' => BrandImage::class,
                    ],
                ],
            ],
        ];
    }

    #[Test]
    public function it_registers_event_subscribers(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService(BrandDeletionSubscriber::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            BrandDeletionSubscriber::class,
            'kernel.event_subscriber',
        );

        $this->assertContainerBuilderHasService(ImageUploadSubscriber::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            ImageUploadSubscriber::class,
            'kernel.event_subscriber',
        );

        $this->assertContainerBuilderHasService(AdminMenuSubscriber::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            AdminMenuSubscriber::class,
            'kernel.event_subscriber',
        );
    }

    #[Test]
    public function it_registers_brand_image_factory_decorator(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService(
            'loevgaard_sylius_brand.custom_factory.brand_image',
            BrandImageFactory::class,
        );
    }

    #[Test]
    public function it_registers_form_types(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService(BrandType::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(BrandType::class, 'form.type');

        $this->assertContainerBuilderHasService(BrandImageType::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(BrandImageType::class, 'form.type');

        $this->assertContainerBuilderHasService(BrandAutocompleteChoiceType::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(BrandAutocompleteChoiceType::class, 'form.type');
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            BrandAutocompleteChoiceType::class,
            'ux.entity_autocomplete_field',
        );
    }

    #[Test]
    public function it_registers_product_form_type_extension(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService(ProductTypeExtension::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            ProductTypeExtension::class,
            'form.type_extension',
            ['extended_type' => ProductType::class],
        );
    }

    #[Test]
    public function it_registers_fixture_services(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService('loevgaard_sylius_brand.fixture.brand', BrandFixture::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'loevgaard_sylius_brand.fixture.brand',
            'sylius_fixtures.fixture',
        );

        $this->assertContainerBuilderHasService(
            'loevgaard_sylius_brand.fixture.example_factory.brand',
            BrandExampleFactory::class,
        );
    }

    #[Test]
    public function it_registers_twig_component(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService(
            'loevgaard_sylius_brand.twig.component.brand.form',
            FormComponent::class,
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'loevgaard_sylius_brand.twig.component.brand.form',
            'sylius.live_component.admin',
            ['key' => 'loevgaard_sylius_brand:brand:form'],
        );
    }

    #[Test]
    public function it_registers_images_upload_listener(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService(
            'loevgaard_sylius_brand.listener.images_upload',
            ImagesUploadListener::class,
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'loevgaard_sylius_brand.listener.images_upload',
            'kernel.event_listener',
            ['event' => 'loevgaard_sylius_brand.brand.pre_create', 'method' => 'uploadImages'],
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'loevgaard_sylius_brand.listener.images_upload',
            'kernel.event_listener',
            ['event' => 'loevgaard_sylius_brand.brand.pre_update', 'method' => 'uploadImages'],
        );
    }

    #[Test]
    public function it_sets_form_validation_groups_parameters(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter(
            'loevgaard_sylius_brand.form.type.brand.validation_groups',
            ['loevgaard_sylius_brand'],
        );
        $this->assertContainerBuilderHasParameter(
            'loevgaard_sylius_brand.form.type.brand_image.validation_groups',
            ['loevgaard_sylius_brand'],
        );
    }

    #[Test]
    public function it_sets_model_class_parameters(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('loevgaard_sylius_brand.model.brand.class', Brand::class);
        $this->assertContainerBuilderHasParameter('loevgaard_sylius_brand.model.brand_image.class', BrandImage::class);
    }
}
