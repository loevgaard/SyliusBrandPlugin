<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\EventSubscriber;

use Loevgaard\SyliusBrandPlugin\EventSubscriber\ImageUploadSubscriber;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;

class ImageUploadSubscriberTest extends TestCase
{
    use ProphecyTrait;

    #[Test]
    public function it_subscribes_to_brand_image_pre_create_event(): void
    {
        $events = ImageUploadSubscriber::getSubscribedEvents();

        self::assertArrayHasKey('loevgaard_sylius_brand.brand_image.pre_create', $events);
        self::assertSame('uploadImage', $events['loevgaard_sylius_brand.brand_image.pre_create']);
    }

    #[Test]
    public function it_uploads_image_when_file_exists(): void
    {
        $image = $this->prophesize(ImageInterface::class);
        $image->hasFile()->willReturn(true);
        $image->getPath()->willReturn('/path/to/image.jpg');

        $uploader = $this->prophesize(ImageUploaderInterface::class);
        $uploader->upload($image->reveal())->shouldBeCalledOnce();

        $event = $this->prophesize(ResourceControllerEvent::class);
        $event->getSubject()->willReturn($image->reveal());
        $event->stop()->shouldNotBeCalled();

        $subscriber = new ImageUploadSubscriber($uploader->reveal());
        $subscriber->uploadImage($event->reveal());
    }

    #[Test]
    public function it_does_not_upload_when_file_does_not_exist(): void
    {
        $image = $this->prophesize(ImageInterface::class);
        $image->hasFile()->willReturn(false);
        $image->getPath()->willReturn('/existing/path.jpg');

        $uploader = $this->prophesize(ImageUploaderInterface::class);
        $uploader->upload()->shouldNotBeCalled();

        $event = $this->prophesize(ResourceControllerEvent::class);
        $event->getSubject()->willReturn($image->reveal());
        $event->stop()->shouldNotBeCalled();

        $subscriber = new ImageUploadSubscriber($uploader->reveal());
        $subscriber->uploadImage($event->reveal());
    }

    #[Test]
    public function it_stops_event_when_path_is_null_after_upload(): void
    {
        $image = $this->prophesize(ImageInterface::class);
        $image->hasFile()->willReturn(true);
        $image->getPath()->willReturn(null);

        $uploader = $this->prophesize(ImageUploaderInterface::class);
        $uploader->upload($image->reveal())->shouldBeCalledOnce();

        $event = $this->prophesize(ResourceControllerEvent::class);
        $event->getSubject()->willReturn($image->reveal());
        $event->stop('loevgaard_sylius_brand.brand_image.upload_error')->shouldBeCalledOnce();

        $subscriber = new ImageUploadSubscriber($uploader->reveal());
        $subscriber->uploadImage($event->reveal());
    }
}
