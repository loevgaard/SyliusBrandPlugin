<?php

declare(strict_types = 1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Loevgaard\SyliusBrandPlugin\Entity\Brand;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    public function testInitialState()
    {
        $brand = new Brand();
        $this->assertEquals(null, $brand->getId());
        $this->assertEquals(null, $brand->getName());
        $this->assertEquals(null, $brand->getSlug());
        $this->assertInstanceOf(ArrayCollection::class, $brand->getImages());
    }

    public function testMutability()
    {
        $brand = new Brand();
        $brand->setId(1)->setName('name')->setSlug('slug');

        $this->assertEquals(1, $brand->getId());
        $this->assertEquals('name', $brand->getName());
        $this->assertEquals('slug', $brand->getSlug());
    }
}
