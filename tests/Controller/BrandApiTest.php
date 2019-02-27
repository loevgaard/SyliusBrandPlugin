<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Controller;

use Loevgaard\SyliusBrandPlugin\Entity\BrandInterface;
use Symfony\Component\HttpFoundation\Response;

final class BrandApiTest extends AbstractApiTestCase
{
    /**
     * @test
     */
    public function it_does_not_allow_to_show_brands_list_when_access_is_denied()
    {
        $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandUrl());

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_show_brand_when_it_does_not_exist()
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandUrl(-1), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_allows_indexing_brands()
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandUrl(), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/index_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_allows_showing_brand()
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',

            // We load products, but they shouldn't be at response.
            // As it could be huge. There are separate endpoint for this.
            'resources/products.yml',
        ]);

        $this->client->request('GET', $this->getBrandUrl($entities['brand_setono']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/show_response', Response::HTTP_OK);
    }

    /**
     * @param BrandInterface|string $brand
     * @return string
     */
    private function getBrandUrl($brand = '')
    {
        return sprintf('/api/v1/brands/%s',
            $brand instanceof BrandInterface ? $brand->getSlug() : $brand
        );
    }
}
