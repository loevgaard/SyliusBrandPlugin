<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Behat\Context\Admin;

use Behat\Behat\Context\Context;
use Tests\Loevgaard\SyliusBrandPlugin\Behat\Page\Admin\Brand\CreateBrandPage;
use Tests\Loevgaard\SyliusBrandPlugin\Behat\Page\Admin\Brand\IndexBrandPage;
use Webmozart\Assert\Assert;

final class ManagingBrandsContext implements Context
{
    /**
     * @var IndexBrandPage
     */
    private $indexBrandPage;

    /**
     * @var CreateBrandPage
     */
    private $createBrandPage;

    public function __construct(IndexBrandPage $indexBrandPage, CreateBrandPage $createBrandPage)
    {
        $this->indexBrandPage = $indexBrandPage;
        $this->createBrandPage = $createBrandPage;
    }

    /**
     * @Given I want to create a new brand
     */
    public function iWantToCreateANewBrand()
    {
        $this->createBrandPage->open();
    }

    /**
     * @When I name it :name
     */
    public function iNameIt($name)
    {
        $this->createBrandPage->nameIt($name);
    }

    /**
     * @When I set its slug to :slug
     */
    public function iSetItsSlugTo($slug)
    {
        $this->createBrandPage->specifySlug($slug);
    }

    /**
     * @When I add it
     */
    public function iAddIt()
    {
        $this->createBrandPage->create();
    }

    /**
     * @Then the brand :brand should appear in the store
     */
    public function theBrandShouldAppearInTheStore($brand)
    {
        $this->indexBrandPage->open();

        Assert::true(
            $this->indexBrandPage->isSingleResourceOnPage(['name' => $brand]),
            sprintf('Brand %s should exist but it does not', $brand)
        );
    }
}
