# Sylius Brand Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

If you want to add a brand to your products this is the plugin to use. Use cases:
- Add brand logo to your product pages
- Filter by brand in the frontend or backend, i.e. product lists

## Installation

### Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```bash
$ composer require loevgaard/sylius-brand-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in `config/bundles.php` file of your project:

```php
<?php

return [
    // ...
    Loevgaard\SyliusBrandPlugin\LoevgaardSyliusBrandPlugin::class => ['all' => true],
    // ...
}
```

### Step 3: Configure the plugin

```yaml
# config/packages/loevgaard_sylius_brand.yaml

imports:
    # ...
    - { resource: "@LoevgaardSyliusBrandPlugin/Resources/config/config.yml" }
```

```yaml
# config/routes/loevgaard_sylius_brand.yaml

loevgaard_sylius_brand:
    resource: "@LoevgaardSyliusBrandPlugin/Resources/config/routing.yml"
```

### Step 4: Import product trait

```php
<?php
// src/Entity/Product.php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Loevgaard\SyliusBrandPlugin\Entity\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Entity\ProductTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * @ORM\MappedSuperclass()
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements BrandAwareInterface
{
    use ProductTrait;
    
    // ...
}
```

**NOTE:** If you haven't extended the `Product` entity yet, follow the [customization instructions](https://docs.sylius.com/en/1.3/customization/model.html) first because you need to add a bit more configuration.

### Step 5: Update your database schema
```bash
$ php bin/console doctrine:schema:update --force
```

or use [Doctrine Migrations](https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html).

## Fixtures

 1. Add a new yaml file to the folder `config/packages` and name it as you wish, e.g. `my_own_fixtures.yaml`.

 2. Fill this yaml with your own brand fixtures and don't forget to declare the definition of
   your product(s) before this brand definition or use existing product(s) code.
    ```
    # config/packages/my_own_fixtures.yaml
    
    sylius_fixtures:
       suites:
           my_own_brand_fixtures:
                fixtures:
                    loevgaard_sylius_brand_plugin_brand:
                        options:
                            custom:
                                flux:
                                    name: 'My brand'
                                    slug: 'my-brand'
                                    products:
                                      - product_code_1
                                      - product_code_2
                                      - product_code_3
    ```

 3. Load your fixtures

    ```bash
    php bin/console sylius:fixture:load my_own_brand_fixtures
    ```
## Installation and usage for plugin development
[Find more information here](install-dev.md)

## Contribute by translating
We use the same service as Sylius for translating, namely [Crowdin](https://crowdin.com/project/sylius-brand-plugin). You can help out by translating this project into your mother tongue ;)

Thanks!

[ico-version]: https://img.shields.io/packagist/v/loevgaard/sylius-brand-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/loevgaard/SyliusBrandPlugin/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/loevgaard/SyliusBrandPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/loevgaard/sylius-brand-plugin
[link-travis]: https://travis-ci.org/loevgaard/SyliusBrandPlugin
[link-code-quality]: https://scrutinizer-ci.com/g/loevgaard/SyliusBrandPlugin
