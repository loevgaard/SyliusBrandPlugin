<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Type;

use Loevgaard\SyliusBrandPlugin\Entity\Brand;
use PHPUnit\Framework\MockObject\MockObject;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class BrandChoiceTypeTest extends TypeTestCase
{
    /**
     * @var MockObject|RepositoryInterface
     */
    private $brandRepository;

    protected function setUp()
    {
        $brand = new Brand();
        $brand->setName('brand name');
        $brand->setSlug('brand-name');

        $this->brandRepository = $this->createMock(RepositoryInterface::class);
        $this->brandRepository->method('findBy')->willReturn([$brand]);

        parent::setUp();
    }

    protected function getExtensions()
    {
        // create a type instance with the mocked dependencies
        $type = new BrandChoiceType($this->brandRepository);

        return [
            // register the type instances with the PreloadedExtension
            new PreloadedExtension([$type], []),
        ];
    }

    public function testSubmitValidData()
    {
        $formData = [
            'test' => 'test',
            'test2' => 'test2',
        ];

        //$objectToCompare = new TestObject();
        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(BrandChoiceType::class);

        //$object = new TestObject();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        //$form->submit($formData);

        //$this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        //$this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        //$children = $view->children;

        //foreach (array_keys($formData) as $key) {
            //$this->assertArrayHasKey($key, $children);
        //}
    }
}
