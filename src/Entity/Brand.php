<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Entity;

class Brand implements BrandInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return intval($this->id);
    }

    /**
     * @param int $id
     * @return Brand
     */
    public function setId(int $id) : BrandInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return (string)$this->slug;
    }

    /**
     * @param string $slug
     * @return Brand
     */
    public function setSlug(string $slug) : BrandInterface
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     * @return Brand
     */
    public function setName(string $name) : BrandInterface
    {
        $this->name = $name;
        return $this;
    }
}