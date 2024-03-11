<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Loevgaard\SyliusBrandPlugin\Model\Brand;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    public function testInitialState(): void
    {
        $brand = new Brand();
        $this->assertEquals(null, $brand->getId());
        $this->assertEquals(null, $brand->getName());
        $this->assertEquals(null, $brand->getCode());
        $this->assertInstanceOf(ArrayCollection::class, $brand->getImages());
    }

    public function testMutability(): void
    {
        $brand = new Brand();
        $brand->setName('name');
        $brand->setCode('code');

        $this->assertEquals(null, $brand->getId());
        $this->assertEquals('name', $brand->getName());
        $this->assertEquals('code', $brand->getCode());
    }
}
