<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Controller;

use Loevgaard\SyliusBrandPlugin\Model\BrandImageInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

final class BrandImageApiTest extends AbstractApiTestCase
{
    /**
     * @test
     */
    public function it_does_not_allow_to_show_brand_images_list_when_access_is_denied(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_setono']));

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_show_brand_image_when_it_does_not_exist(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_setono'],-1), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_allows_indexing_brand_images(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_setono']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand_image/index_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_allows_paginating_and_limiting_the_index_of_brand_images(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_setono']), ['page' => 2, 'limit' => 1], [], static::$authorizedHeaderWithAccept);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand_image/index_response_paginated');
    }

    /**
     * @test
     */
    public function it_allows_filter_by_type_the_index_of_brand_images(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandImageByTypeUrl($entities['brand_setono'], 'logo'), [], [], static::$authorizedHeaderWithAccept);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand_image/index_by_type_response');
    }

    /**
     * @test
     */
    public function it_denies_showing_brand_image_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']));

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_allows_showing_brand_image(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand_image/show_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_denies_brand_image_deletion_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('DELETE', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']));

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_delete_brand_image_if_it_does_not_exist(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('DELETE', $this->getBrandImageUrl($entities['brand_sylius'], -1), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_allows_delete_brand_image(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('DELETE', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_denies_brand_image_creation_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('POST', $this->getBrandImageUrl($entities['brand_sylius']), [], [], self::$headerWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_create_brand_image_without_required_fields(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $this->client->request('POST', $this->getBrandImageUrl($entities['brand_sylius']), [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand_image/create_validation_fail_response', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @test
     */
    public function it_allows_create_brand_image(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $data =
<<<EOT
        {
            "type": "logo"
        }
EOT;

        $this->client->request(
            'POST',
            $this->getBrandImageUrl($entities['brand_sylius']),
            [],
            ['file' => new UploadedFile(sprintf('%s/../Resources/fixtures/php-logo.png', __DIR__), 'php-logo')],
            static::$authorizedHeaderWithContentType,
            $data
        );

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand_image/create_response', Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_denies_partial_updating_brand_image_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('PATCH', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], self::$headerWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_allows_updating_partial_information_about_brand_image(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $data =
<<<EOT
        {
            "type": "updated-type"
        }
EOT;
        $this->client->request('PATCH', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], static::$authorizedHeaderWithContentType, $data);
        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand_image/show_after_partial_update_response');
    }

    /**
     * @test
     */
    public function it_denies_updating_brand_image_for_non_authenticated_user(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'resources/brands.yml',
        ]);

        $this->client->request('PUT', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], self::$headerWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_allows_updating_brand_image(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
        ]);

        $data =
<<<EOT
        {
              "type": "updated-type"
        }
EOT;
        $this->client->request('PUT', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], static::$authorizedHeaderWithContentType, $data);
        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $this->getBrandImageUrl($entities['brand_sylius'], $entities['brand_image_sylius_logo']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'brand_image/show_after_update_response');
    }

    /**
     * @param BrandInterface $brand
     * @param BrandImageInterface|string $brandImage
     * @return string
     */
    private function getBrandImageUrl(BrandInterface $brand, $brandImage = ''): string
    {
        return sprintf('/api/v1/brands/%s/images/%s',
            $brand->getCode(),
            $brandImage instanceof BrandImageInterface ? $brandImage->getId() : $brandImage
        );
    }

    /**
     * @param BrandInterface $brand
     * @param string $type
     * @return string
     */
    private function getBrandImageByTypeUrl(BrandInterface $brand, string $type): string
    {
        return sprintf(
            '/api/v1/brands/%s/images/by-type/%s',
            $brand->getCode(),
            $type
        );
    }

}
