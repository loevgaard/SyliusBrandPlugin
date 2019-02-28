<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Controller;

use Loevgaard\SyliusBrandPlugin\Entity\ProductInterface;
use Symfony\Component\HttpFoundation\Response;

final class ProductApiTest extends AbstractApiTestCase
{
    /**
     * @test
     */
    public function it_allows_indexing_products_with_brand_field()
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
    public function it_allows_showing_product_with_brand_field()
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
    public function it_allows_updating_product_brand()
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        $data =
<<<EOT
        {
            "brand": "{$entities['brand_sylius']->getSlug()}"
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
    public function it_allows_updating_partial_information_about_product()
    {
        $entities = $this->loadDefaultFixtureFiles([
            'authentication/api_administrator.yml',
            'resources/brands.yml',
            'resources/products.yml',
        ]);

        $data =
<<<EOT
        {
            "brand": "{$entities['brand_sylius']->getSlug()}"
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
     * @return string
     */
    private function getProductUrl($product = '')
    {
        return sprintf(
            '/api/v1/products/%s',
            $product instanceof ProductInterface ? $product->getCode() : $product
        );
    }
}
