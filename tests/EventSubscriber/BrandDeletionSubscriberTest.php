<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\EventSubscriber;

use Loevgaard\SyliusBrandPlugin\EventSubscriber\BrandDeletionSubscriber;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;

class BrandDeletionSubscriberTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function it_subscribes_to_brand_pre_delete_event(): void
    {
        $events = BrandDeletionSubscriber::getSubscribedEvents();

        self::assertArrayHasKey('loevgaard_sylius_brand.brand.pre_delete', $events);
        self::assertSame('guard', $events['loevgaard_sylius_brand.brand.pre_delete']);
    }

    /** @test */
    public function it_allows_deletion_when_brand_has_no_products(): void
    {
        $brand = $this->prophesize(BrandInterface::class);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productRepository->findOneBy(['brand' => $brand->reveal()])->willReturn(null);

        $event = $this->prophesize(ResourceControllerEvent::class);
        $event->getSubject()->willReturn($brand->reveal());
        $event->stop()->shouldNotBeCalled();

        $subscriber = new BrandDeletionSubscriber($productRepository->reveal());
        $subscriber->guard($event->reveal());
    }

    /** @test */
    public function it_stops_deletion_when_brand_is_used_in_products(): void
    {
        $brand = $this->prophesize(BrandInterface::class);
        $product = $this->prophesize(ProductInterface::class);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productRepository->findOneBy(['brand' => $brand->reveal()])->willReturn($product->reveal());

        $event = $this->prophesize(ResourceControllerEvent::class);
        $event->getSubject()->willReturn($brand->reveal());
        $event->stop('loevgaard_sylius_brand.brand.delete_error')->shouldBeCalledOnce();

        $subscriber = new BrandDeletionSubscriber($productRepository->reveal());
        $subscriber->guard($event->reveal());
    }

    /** @test */
    public function it_throws_exception_for_non_brand_subject(): void
    {
        $productRepository = $this->prophesize(ProductRepositoryInterface::class);

        $event = $this->prophesize(ResourceControllerEvent::class);
        $event->getSubject()->willReturn(new \stdClass());

        $subscriber = new BrandDeletionSubscriber($productRepository->reveal());

        $this->expectException(UnexpectedTypeException::class);
        $subscriber->guard($event->reveal());
    }
}
