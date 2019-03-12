<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocSignatureInspection */

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Tests\Loevgaard\SyliusBrandPlugin\Behat\Page\Admin\Brand\CreateBrandPage;
use Tests\Loevgaard\SyliusBrandPlugin\Behat\Page\Admin\Brand\IndexBrandPage;
use Tests\Loevgaard\SyliusBrandPlugin\Behat\Page\Admin\Brand\UpdateBrandPage;
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

    /**
     * @var UpdateBrandPage
     */
    private $updateBrandPage;

    public function __construct(IndexBrandPage $indexBrandPage, CreateBrandPage $createBrandPage, UpdateBrandPage $updateBrandPage)
    {
        $this->indexBrandPage = $indexBrandPage;
        $this->createBrandPage = $createBrandPage;
        $this->updateBrandPage = $updateBrandPage;
    }

    /**
     * @Given I want to create a new brand
     */
    public function iWantToCreateANewBrand(): void
    {
        $this->createBrandPage->open();
    }

    /**
     * @When I name it :name
     */
    public function iNameIt($name): void
    {
        $this->createBrandPage->nameIt($name);
    }

    /**
     * @When I set its code to :code
     */
    public function iSetItsCodeTo($code): void
    {
        $this->createBrandPage->specifyCode($code);
    }

    /**
     * @When I add it
     */
    public function iAddIt(): void
    {
        $this->createBrandPage->create();
    }

    /**
     * @Then the brand :brand should appear in the store
     */
    public function theBrandShouldAppearInTheStore($brand): void
    {
        $this->indexBrandPage->open();

        Assert::true(
            $this->indexBrandPage->isSingleResourceOnPage(['name' => $brand]),
            sprintf('Brand %s should exist but it does not', $brand)
        );
    }

    /**
     * @Given I want to modify the :brand brand
     */
    public function iWantToModifyTheBrand(BrandInterface $brand): void
    {
        $this->updateBrandPage->open([
            'id' => $brand->getId(),
        ]);
    }

    /**
     * @When I rename it to :name
     */
    public function iRenameItTo($name): void
    {
        $this->updateBrandPage->nameIt($name);
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges(): void
    {
        $this->updateBrandPage->saveChanges();
    }

    /**
     * @Then this brand name should be :name
     */
    public function thisBrandNameShouldBe($name): void
    {
        Assert::eq($name, $this->updateBrandPage->getName());
    }
}
