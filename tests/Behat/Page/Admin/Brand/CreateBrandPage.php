<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Behat\Page\Admin\Brand;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

class CreateBrandPage extends BaseCreatePage
{
    public function nameIt($name): void
    {
        $this->getElement('name')->setValue($name);
    }

    public function specifyCode($code): void
    {
        $this->getElement('code')->setValue($code);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '#loevgaard_sylius_brand_brand_name',
            'code' => '#loevgaard_sylius_brand_brand_code',
        ]);
    }
}
