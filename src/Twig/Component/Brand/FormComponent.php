<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Twig\Component\Brand;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Sylius\Bundle\UiBundle\Twig\Component\LiveCollectionTrait;
use Sylius\Bundle\UiBundle\Twig\Component\ResourceFormComponentTrait;
use Sylius\Bundle\UiBundle\Twig\Component\TemplatePropTrait;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentToolsTrait;

#[AsLiveComponent]
class FormComponent
{
    use ComponentToolsTrait;
    use LiveCollectionTrait;
    use TemplatePropTrait;

    /** @use ResourceFormComponentTrait<BrandInterface> */
    use ResourceFormComponentTrait;

    /**
     * @param RepositoryInterface<BrandInterface> $brandRepository
     */
    public function __construct(
        RepositoryInterface $brandRepository,
        FormFactoryInterface $formFactory,
        string $resourceClass,
        string $formClass,
    ) {
        $this->initialize($brandRepository, $formFactory, $resourceClass, $formClass);
    }

    protected function getDataModelValue(): string
    {
        return 'norender|*';
    }
}
