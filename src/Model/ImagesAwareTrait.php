<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ImageInterface;

trait ImagesAwareTrait
{
    /** @var Collection<array-key, ImageInterface> */
    protected Collection $images;

    public function __construct()
    {
        /** @var ArrayCollection<array-key, ImageInterface> $images */
        $images = new ArrayCollection();
        $this->images = $images;
    }

    /** @return Collection<array-key, ImageInterface> */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /** @return Collection<array-key, ImageInterface> */
    public function getImagesByType(string $type): Collection
    {
        return $this->images->filter(fn (ImageInterface $image) => $type === $image->getType());
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function hasImage(ImageInterface $image): bool
    {
        return $this->images->contains($image);
    }

    public function addImage(ImageInterface $image): void
    {
        if (false === $this->hasImage($image)) {
            $image->setOwner($this);
            $this->images->add($image);
        }
    }

    public function removeImage(ImageInterface $image): void
    {
        if ($this->hasImage($image)) {
            $image->setOwner(null);
            $this->images->removeElement($image);
        }
    }
}
