<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\EventSubscriber;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class BrandDeletionSubscriber implements EventSubscriberInterface
{
    /**
     * @param ProductRepositoryInterface<ProductInterface> $productRepository
     */
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'loevgaard_sylius_brand.brand.pre_delete' => 'guard',
        ];
    }

    /**
     * Prevent brand deletion if it used in product
     */
    public function guard(ResourceControllerEvent $event): void
    {
        $brand = $event->getSubject();

        if (!$brand instanceof BrandInterface) {
            throw new UnexpectedTypeException($brand, BrandInterface::class);
        }

        if ($this->productRepository->findOneBy(['brand' => $brand]) === null) {
            return;
        }

        $event->stop('loevgaard_sylius_brand.brand.delete_error');
    }
}
