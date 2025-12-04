<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\EventSubscriber;

use Knp\Menu\ItemInterface;
use Loevgaard\SyliusBrandPlugin\EventSubscriber\AdminMenuSubscriber;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuSubscriberTest extends TestCase
{
    use ProphecyTrait;

    #[Test]
    public function it_subscribes_to_admin_menu_event(): void
    {
        $events = AdminMenuSubscriber::getSubscribedEvents();

        self::assertArrayHasKey('sylius.menu.admin.main', $events);
        self::assertSame('add', $events['sylius.menu.admin.main']);
    }

    #[Test]
    public function it_adds_brands_menu_item_to_catalog_section(): void
    {
        $brandsItem = $this->prophesize(ItemInterface::class);
        $brandsItem->setLabel('loevgaard_sylius_brand.ui.brands')->willReturn($brandsItem->reveal())->shouldBeCalledOnce();
        $brandsItem->setLabelAttribute('icon', 'building')->shouldBeCalledOnce();

        $catalogItem = $this->prophesize(ItemInterface::class);
        $catalogItem->addChild('brands', ['route' => 'loevgaard_sylius_brand_admin_brand_index'])
            ->willReturn($brandsItem->reveal())
            ->shouldBeCalledOnce();

        $menu = $this->prophesize(ItemInterface::class);
        $menu->getChild('catalog')->willReturn($catalogItem->reveal());

        $event = $this->prophesize(MenuBuilderEvent::class);
        $event->getMenu()->willReturn($menu->reveal());

        $subscriber = new AdminMenuSubscriber();
        $subscriber->add($event->reveal());
    }

    #[Test]
    public function it_adds_brands_menu_item_to_first_child_when_catalog_does_not_exist(): void
    {
        $brandsItem = $this->prophesize(ItemInterface::class);
        $brandsItem->setLabel('loevgaard_sylius_brand.ui.brands')->willReturn($brandsItem->reveal())->shouldBeCalledOnce();
        $brandsItem->setLabelAttribute('icon', 'building')->shouldBeCalledOnce();

        $firstChild = $this->prophesize(ItemInterface::class);
        $firstChild->addChild('brands', ['route' => 'loevgaard_sylius_brand_admin_brand_index'])
            ->willReturn($brandsItem->reveal())
            ->shouldBeCalledOnce();

        $menu = $this->prophesize(ItemInterface::class);
        $menu->getChild('catalog')->willReturn(null);
        $menu->getFirstChild()->willReturn($firstChild->reveal());

        $event = $this->prophesize(MenuBuilderEvent::class);
        $event->getMenu()->willReturn($menu->reveal());

        $subscriber = new AdminMenuSubscriber();
        $subscriber->add($event->reveal());
    }
}
