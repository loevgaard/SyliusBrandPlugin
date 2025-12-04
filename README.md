# Sylius Brand Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]

<a href="https://sylius.com/plugins/" target="_blank"><img src="https://sylius.com/assets/badge-approved-by-sylius.png" width="100"></a>

Add brand to your products in Sylius.

## Requirements

- PHP 8.2+
- Sylius 2.0+
- Symfony 6.4 or 7.4

## Installation

### Step 1: Download the plugin

```bash
composer require loevgaard/sylius-brand-plugin
```

### Step 2: Enable the plugin

Enable the plugin by adding it to the list of registered plugins/bundles
in `config/bundles.php` file of your project before (!) `SyliusGridBundle`:

```php
<?php

# config/bundles.php

return [
    // ...
    Loevgaard\SyliusBrandPlugin\LoevgaardSyliusBrandPlugin::class => ['all' => true],
    Sylius\Bundle\GridBundle\SyliusGridBundle::class => ['all' => true],
    // ...
];
```

### Step 3: Configure routing

```yaml
# config/routes/loevgaard_sylius_brand.yaml

loevgaard_sylius_brand:
    resource: "@LoevgaardSyliusBrandPlugin/config/routes.yaml"
```

### Step 4: Extend Product entity

Extend your `Product` entity to implement `BrandAwareInterface`:

```php
<?php
// src/Entity/Product/Product.php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements BrandAwareInterface
{
    use BrandAwareTrait;
}
```

> The `BrandAwareTrait` already includes the Doctrine ORM mapping attributes, so you don't need to add any additional mapping configuration.

### Step 5: Configure Sylius resource

```yaml
# config/packages/sylius_product.yaml

sylius_product:
    resources:
        product:
            classes:
                model: App\Entity\Product\Product
```

> The above configuration is most likely already done in your application.

### Step 6: Update your database schema

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Optional Configuration

### Show Brand column in admin products list

```yaml
# config/packages/loevgaard_sylius_brand.yaml

imports:
    - { resource: "@LoevgaardSyliusBrandPlugin/config/grids/sylius_admin_product.yaml" }
```

## Fixtures

Include predefined brand fixtures to play with on your dev environment:

```yaml
# config/packages/loevgaard_sylius_brand.yaml

imports:
    - { resource: "@LoevgaardSyliusBrandPlugin/config/fixtures.yaml" }
```

Or write your own:

```yaml
# config/packages/my_fixtures.yaml

sylius_fixtures:
    suites:
        my_brand_fixtures:
            fixtures:
                loevgaard_sylius_brand_plugin_brand:
                    options:
                        custom:
                            my_brand:
                                name: 'My brand'
                                code: 'my-brand'
                                images:
                                    - type: logo
                                      path: images/my-brand/logo.jpg
                                products:
                                    - product_code_1
                                    - product_code_2
```

Load your fixtures:

```bash
php bin/console sylius:fixture:load my_brand_fixtures
```

## Development

### Customization

#### Twig Hooks

The plugin uses Sylius Twig Hooks for customization. Available hook points:

**Product form:**
- `sylius_admin.product.create.content.form.sections.general` (priority 250)
- `sylius_admin.product.update.content.form.sections.general` (priority 250)

**Brand form:**
- `loevgaard_sylius_brand.brand.create.content`
- `loevgaard_sylius_brand.brand.update.content`
- `loevgaard_sylius_brand.brand.create.content.form.form_sections.general`
- `loevgaard_sylius_brand.brand.update.content.form.form_sections.general`
- `loevgaard_sylius_brand.brand.create.content.form.form_sections.media`
- `loevgaard_sylius_brand.brand.update.content.form.form_sections.media`

### Translations

Currently supported languages:
- English (en)
- German (de)
- French (fr)
- Spanish (es)
- Italian (it)
- Dutch (nl)
- Polish (pl)
- Danish (da)
- Swedish (sv)
- Norwegian (no)
- Finnish (fi)

[ico-version]: https://img.shields.io/packagist/v/loevgaard/sylius-brand-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-github-actions]: https://img.shields.io/github/actions/workflow/status/loevgaard/SyliusBrandPlugin/build.yaml?branch=master&style=flat-square

[link-packagist]: https://packagist.org/packages/loevgaard/sylius-brand-plugin
[link-github-actions]: https://github.com/loevgaard/SyliusBrandPlugin/actions
