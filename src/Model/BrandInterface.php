<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Sylius\Component\Core\Model\ImagesAwareInterface;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface BrandInterface extends ResourceInterface, CodeAwareInterface, ImagesAwareInterface, \Stringable
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(?string $name): void;
}
