<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Loevgaard\SyliusBrandPlugin\Event\BrandMenuBuilderEvent;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as ContractsEventDispatcherInterface;

final class BrandFormMenuBuilder
{
    public const EVENT_NAME = 'loevgaard_sylius_brand.menu.admin.brand.form';

    /** @var FactoryInterface */
    private $factory;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(FactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;

        if (class_exists('Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy')) {
            /**
             * It could return null only if we pass null, but we pass not null in any case
             *
             * @var ContractsEventDispatcherInterface $eventDispatcher
             */
            $eventDispatcher = LegacyEventDispatcherProxy::decorate($eventDispatcher);
        }

        $this->eventDispatcher = $eventDispatcher;
    }

    public function createMenu(array $options = []): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        if (!array_key_exists('brand', $options) || !$options['brand'] instanceof BrandInterface) {
            return $menu;
        }

        $menu
            ->addChild('details')
            ->setAttribute('template', '@LoevgaardSyliusBrandPlugin/Admin/Brand/Tab/_details.html.twig')
            ->setLabel('sylius.ui.details')
            ->setCurrent(true)
        ;

        $menu
            ->addChild('media')
            ->setAttribute('template', '@LoevgaardSyliusBrandPlugin/Admin/Brand/Tab/_media.html.twig')
            ->setLabel('sylius.ui.media')
        ;

        if (class_exists('Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy')) {
            $this->eventDispatcher->dispatch(
                new BrandMenuBuilderEvent($this->factory, $menu, $options['brand']),
                self::EVENT_NAME,
            );
        } else {
            $this->eventDispatcher->dispatch(
                self::EVENT_NAME,
                new BrandMenuBuilderEvent($this->factory, $menu, $options['brand']),
            );
        }

        return $menu;
    }
}
