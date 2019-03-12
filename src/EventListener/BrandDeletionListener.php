<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\EventListener;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;

final class BrandDeletionListener
{
    /**
     * Prevent brand deletion if it used in product
     *
     * @param ResourceControllerEvent $event
     */
    public function onBrandPreDelete(ResourceControllerEvent $event): void
    {
        $brand = $event->getSubject();

        if (!$brand instanceof BrandInterface) {
            throw new UnexpectedTypeException(
                $brand,
                BrandInterface::class
            );
        }

        if ($brand->hasProducts()) {
            $event->stop('loevgaard_sylius_brand.brand.delete_error');
        }
    }
}
