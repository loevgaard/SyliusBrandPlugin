<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Controller;

use Loevgaard\SyliusBrandPlugin\Model\BrandInterface;
use Loevgaard\SyliusBrandPlugin\Model\ProductInterface;
use Symfony\Component\HttpFoundation\Response;

final class ProductApiTest extends AbstractApiTestCase
{
    /**
     * @test
     */
    public function it_allows_indexing_products_with_brand_field(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        $this->client->request('GET', $this->getProductUrl(), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'product/index_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_allows_showing_product_with_brand_field(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        $this->client->request('GET', $this->getProductUrl($entities['product_setono_mug']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'product/show_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_allows_create_product_with_brand_field(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        /** @var BrandInterface $brand */
        $brand = $entities['brand_setono'];
        $data =
<<<EOT
        {
            "code": "SETONO_BIG_MUG",
            "brand": "{$brand->getCode()}"
        }
EOT;

        $this->client->request('POST', $this->getProductUrl(), [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'product/create_response', Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_create_product_with_invalid_brand_code(): void
    {
        $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        $data =
<<<EOT
        {
            "code": "SETONO_BIG_MUG",
            "brand": "invalid-code"
        }
EOT;

        $this->client->request('POST', $this->getProductUrl(), [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'product/create_validation_fail_response', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_allows_updating_product_brand(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        /** @var BrandInterface $brand */
        $brand = $entities['brand_sylius'];
        $data =
<<<EOT
        {
            "brand": "{$brand->getCode()}"
        }
EOT;

        $this->client->request('PUT', $this->getProductUrl($entities['product_setono_mug']), [], [], static::$authorizedHeaderWithContentType, $data);
        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $this->getProductUrl($entities['product_setono_mug']), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'product/show_after_update_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_allows_updating_partial_information_about_product(): void
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        /** @var BrandInterface $brand */
        $brand = $entities['brand_sylius'];
        $data =
<<<EOT
        {
            "brand": "{$brand->getCode()}"
        }
EOT;

        $this->client->request('PATCH', $this->getProductUrl($entities['product_setono_mug']), [], [], static::$authorizedHeaderWithContentType, $data);
        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $this->getProductUrl($entities['product_setono_mug']), [], [], static::$authorizedHeaderWithAccept);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'product/show_after_update_response', Response::HTTP_OK);
    }

    /**
     * @param ProductInterface|string $product
     */
    private function getProductUrl($product = ''): string
    {
        return sprintf(
            '/api/v1/products/%s',
            $product instanceof ProductInterface ? $product->getCode() : $product,
        );
    }
}
