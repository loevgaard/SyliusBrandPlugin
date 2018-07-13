<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Type;

use Loevgaard\SyliusBrandPlugin\Entity\Brand;
use Loevgaard\SyliusBrandPlugin\Repository\BrandRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class BrandChoiceTypeTest extends TypeTestCase
{
    /**
     * @var MockObject|BrandRepositoryInterface
     */
    private $brandRepository;

    protected function setUp()
    {
        $brand = new Brand();
        $brand
            ->setId(1)
            ->setName('brand name')
            ->setSlug('brand-name')
        ;

        $this->brandRepository = $this->createMock(BrandRepositoryInterface::class);
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
