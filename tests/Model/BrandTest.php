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
        self::assertNull($brand->getId());
        self::assertNull($brand->getName());
        self::assertNull($brand->getCode());
        self::assertInstanceOf(ArrayCollection::class, $brand->getImages());
    }

    public function testMutability(): void
    {
        $brand = new Brand();
        $brand->setName('name');
        $brand->setCode('code');

        self::assertNull($brand->getId());
        self::assertSame('name', $brand->getName());
        self::assertSame('code', $brand->getCode());
    }
}
