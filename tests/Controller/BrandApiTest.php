<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Controller;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

final class BrandApiTest extends AbstractApiTestCase
{
    /**
     * @test
     */
    public function it_does_not_allow_to_show_brands_list_when_access_is_denied(): void
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
    public function it_does_not_allow_to_show_brand_when_it_does_not_exist(): void
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
    public function it_allows_indexing_brands(): void
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
    public function it_allows_paginating_and_limiting_the_index_of_brands(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/many_brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandUrl(), ['page' => 2, 'limit' => 3], [], static::$authorizedHeaderWithAccept);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/index_response_paginated');
    }

    /**
     * @test
     */
    public function it_allows_sorting_the_index_of_brands(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandUrl(), ['sorting' => ['code' => 'desc']], [], static::$authorizedHeaderWithAccept);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/index_response_sorted');
    }

    /**
     * @test
     */
    public function it_allows_filtering_the_index_of_brands(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandUrl(), ['criteria' => ['search' => ['type' => 'contains', 'value' => 'sylius']]], [], static::$authorizedHeaderWithAccept);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/index_response_filtered');
    }

    /**
     * @test
     */
    public function it_denies_showing_brand_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandUrl($entities['brand_sylius']));

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_allows_showing_brand(): void
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
     * @test
     */
    public function it_denies_brand_deletion_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('DELETE', $this->getBrandUrl($entities['brand_sylius']));

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_delete_brand_if_it_does_not_exist(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
        ]);

        $this->client->request('DELETE', $this->getBrandUrl(-1), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     *
     * Actually, I'm not sure 500 Internal Server Error is good response for REST
     * and that message will be visible in production
     *
     * @todo Find better solution
     */
    public function it_does_not_allow_delete_brand_if_it_used_by_products(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        $this->client->request('DELETE', $this->getBrandUrl($entities['brand_setono']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'error/brand_delete_error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @test
     */
    public function it_allows_delete_brand(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('DELETE', $this->getBrandUrl($entities['brand_setono']), [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $this->getBrandUrl($entities['brand_setono']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_denies_brand_creation_for_non_authenticated_user(): void
    {
        $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('POST', $this->getBrandUrl(), [], [], self::$headerWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_create_brand_without_required_fields(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
        ]);

        $this->client->request('POST', $this->getBrandUrl(), [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/create_validation_fail_response', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_create_brand_with_too_long_name_and_code(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
        ]);

        $longString = str_repeat('s', 256);

        $data =
<<<EOT
        {
            "name": "{$longString}",
            "code": "{$longString}"
        }
EOT;

        $this->client->request('POST', $this->getBrandUrl(), [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/create_with_long_name_and_code_validation_fail_response', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_create_brand_with_too_short_name(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
        ]);

        $data =
            <<<EOT
        {
            "name": "s",
            "code": "valid-code"
        }
EOT;

        $this->client->request('POST', $this->getBrandUrl(), [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/create_with_short_name_validation_fail_response', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_allows_create_brand(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
        ]);

        $data =
            <<<EOT
        {
            "name": "Brand name",
            "code": "brand-code"
        }
EOT;

        $this->client->request('POST', $this->getBrandUrl(), [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/create_response', Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_allows_creating_brand_with_images(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
        ]);

        $data =
<<<EOT
        {
            "name": "PHP",
            "code": "php",
            "images": [
                {
                    "type": "logo"
                },
                {
                    "type": "logo"
                }
            ]
        }
EOT;

        $this->client->request(
            'POST',
            $this->getBrandUrl(),
            [],
            ['images' => [
                ['file' => new UploadedFile(sprintf('%s/../Resources/fixtures/php-logo.png', __DIR__), 'php-logo')],
                ['file' => new UploadedFile(sprintf('%s/../Resources/fixtures/php-logo-transparent-background.png', __DIR__), 'php-logo-transparent-background')],
            ]],
            static::$authorizedHeaderWithContentType,
            $data,
        );

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/create_with_images_response', Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_denies_partial_updating_brand_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('PATCH', $this->getBrandUrl($entities['brand_sylius']), [], [], self::$headerWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_allows_updating_partial_information_about_brand(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $data =
<<<EOT
        {
            "name": "Updated name"
        }
EOT;
        $this->client->request('PATCH', $this->getBrandUrl($entities['brand_symfony']), [], [], static::$authorizedHeaderWithContentType, $data);
        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $this->getBrandUrl($entities['brand_symfony']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/show_after_partial_update_response');
    }

    /**
     * @test
     */
    public function it_denies_updating_brand_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('PUT', $this->getBrandUrl($entities['brand_sylius']), [], [], self::$headerWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_allows_updating_brand(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        // Code field is not updatable
        $data =
<<<EOT
        {
              "name": "Updated name"
        }
EOT;
        $this->client->request('PUT', $this->getBrandUrl($entities['brand_symfony']), [], [], static::$authorizedHeaderWithContentType, $data);
        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $this->getBrandUrl($entities['brand_symfony']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand/show_after_update_response');
    }

    /**
     * @param BrandInterface|string $brand
     */
    private function getBrandUrl($brand = ''): string
    {
        return sprintf(
            '/api/v1/brands/%s',
            $brand instanceof BrandInterface ? $brand->getCode() : $brand,
        );
    }
}
