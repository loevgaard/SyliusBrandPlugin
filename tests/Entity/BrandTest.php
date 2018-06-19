<?php

declare(strict_types = 1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Entity;

use Loevgaard\SyliusBrandPlugin\Entity\Brand;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    public function testGettersReturnNull()
    {
        $getters = $this->getGetters();
        $brand = new Brand();
        foreach ($getters as $getter) {
            $this->assertEquals(null, $brand->{$getter->getName()}());
        }
    }

    public function testMutability()
    {
        $brand = new Brand();
        $brand->setId(1)->setName('name')->setSlug('slug');

        $this->assertEquals(1, $brand->getId());
        $this->assertEquals('name', $brand->getName());
        $this->assertEquals('slug', $brand->getSlug());
    }

    /**
     * @return \ReflectionProperty[]
     * @throws \ReflectionException
     */
    private function getGetters(): array
    {
        $refl = new \ReflectionClass(Brand::class);
        $methods = $refl->getMethods(\ReflectionMethod::IS_PUBLIC);
        return array_filter($methods, function(\ReflectionMethod $method) {
            return substr($method->getName(), 0, 3) === 'get';
        });
    }
}
