<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\ImageType;

final class BrandImageType extends ImageType
{
    /**
     * @inheritdoc
     */
    public function getBlockPrefix(): string
    {
        return 'loevgaard_sylius_brand_brand_image';
    }
}
