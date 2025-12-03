<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\EventSubscriber;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Webmozart\Assert\Assert;

final readonly class ImageUploadSubscriber implements EventSubscriberInterface
{
    public function __construct(private ImageUploaderInterface $uploader)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'loevgaard_sylius_brand.brand_image.pre_create' => 'uploadImage',
        ];
    }

    public function uploadImage(ResourceControllerEvent $event): void
    {
        $image = $event->getSubject();
        Assert::isInstanceOf($image, ImageInterface::class);

        if ($image->hasFile()) {
            $this->uploader->upload($image);
        }

        if (null === $image->getPath()) {
            $event->stop('loevgaard_sylius_brand.brand_image.upload_error');
        }
    }
}
