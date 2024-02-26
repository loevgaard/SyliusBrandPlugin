<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Loevgaard\SyliusBrandPlugin\Event\BrandMenuBuilderEvent;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

final class BrandFormMenuBuilder
{
    public const EVENT_NAME = 'loevgaard_sylius_brand.menu.admin.brand.form';

    public function __construct(
        private readonly FactoryInterface $factory,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
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
            ->setCurrent(true);

        $menu
            ->addChild('media')
            ->setAttribute('template', '@LoevgaardSyliusBrandPlugin/Admin/Brand/Tab/_media.html.twig')
            ->setLabel('sylius.ui.media');

        if (class_exists('Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy')) {
            $this->eventDispatcher->dispatch(
                new BrandMenuBuilderEvent($this->factory, $menu, $options['brand']),
                self::EVENT_NAME,
            );
        } else {
            $this->eventDispatcher->dispatch(
                new BrandMenuBuilderEvent($this->factory, $menu, $options['brand']),
                self::EVENT_NAME,
            );
        }

        return $menu;
    }
}
