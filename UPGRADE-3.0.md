# Upgrade from v2.x to v3.0

This guide documents the upgrade path from version 2.x to 3.0 of the Sylius Brand Plugin.

## Requirements

- **PHP 8.2+** (was PHP 7.4+)
- **Sylius 2.0+** (was Sylius 1.x)
- **Symfony 6.4 or 7.4** (was Symfony 4.4/5.x/6.x)

## Step 1: Update Composer

```bash
composer require loevgaard/sylius-brand-plugin:^3.0
```

## Step 2: Update Product Entity

### Remove ProductInterface

The `ProductInterface` has been removed. Your Product entity should now implement `BrandAwareInterface` directly:

**Before (v2.x):**
```php
use Loevgaard\SyliusBrandPlugin\Model\ProductInterface as LoevgaardSyliusBrandPluginProductInterface;

class Product extends BaseProduct implements LoevgaardSyliusBrandPluginProductInterface
```

**After (v3.0):**
```php
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface;

class Product extends BaseProduct implements BrandAwareInterface
```

### Use PHP 8 Attributes

The `BrandAwareTrait` now includes Doctrine ORM mapping via PHP 8 attributes. You no longer need separate XML or annotation mapping for the brand relation.

**Before (v2.x with annotations):**
```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Loevgaard\SyliusBrandPlugin\Model\ProductInterface as LoevgaardSyliusBrandPluginProductInterface;
use Loevgaard\SyliusBrandPlugin\Model\BrandAwareTrait as LoevgaardSyliusBrandPluginProductTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements LoevgaardSyliusBrandPluginProductInterface
{
    use LoevgaardSyliusBrandPluginProductTrait;
}
```

**After (v3.0 with PHP 8 attributes):**
```php
<?php

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

### Remove XML Mapping (if used)

If you were using XML mapping, you can now remove it. The trait handles the mapping automatically.

**Remove this file if it exists:**
```bash
rm config/doctrine/model/Product.orm.xml
```

## Step 3: Remove ProductRepository Extension

The `ProductRepositoryInterface` and `ProductRepositoryTrait` have been removed. You no longer need to extend your ProductRepository.

**Remove from your ProductRepository (if extended):**
```php
// Remove these lines:
use Loevgaard\SyliusBrandPlugin\Doctrine\ORM\ProductRepositoryInterface;
use Loevgaard\SyliusBrandPlugin\Doctrine\ORM\ProductRepositoryTrait;

// Remove the interface implementation and trait usage
```

If your ProductRepository only existed for this plugin, you can remove it entirely and update your configuration:

```yaml
# config/packages/sylius_product.yaml

sylius_product:
    resources:
        product:
            classes:
                model: App\Entity\Product\Product
                # Remove the repository line if it was only for the brand plugin
```

## Step 4: Update Configuration Imports

### Remove Main Config Import

The plugin now auto-configures itself via Symfony's prepend mechanism. You no longer need to import the main config file.

**Remove from your configuration:**
```yaml
# Remove this import:
imports:
    - { resource: "@LoevgaardSyliusBrandPlugin/config/app/config.yaml" }
```

### Update Optional Imports (Path Changes)

If you're using optional configuration, update the paths:

**Before (v2.x):**
```yaml
imports:
    - { resource: "@LoevgaardSyliusBrandPlugin/Resources/config/grids/sylius_admin_product.yaml" }
    - { resource: "@LoevgaardSyliusBrandPlugin/Resources/config/fixtures.yaml" }
```

**After (v3.0):**
```yaml
imports:
    - { resource: "@LoevgaardSyliusBrandPlugin/config/grids/sylius_admin_product.yaml" }
    - { resource: "@LoevgaardSyliusBrandPlugin/config/fixtures.yaml" }
```

## Step 5: Update Route Import

**Before (v2.x):**
```yaml
# config/routes/loevgaard_sylius_brand.yaml

loevgaard_sylius_brand:
    resource: "@LoevgaardSyliusBrandPlugin/Resources/config/routes.yaml"
```

**After (v3.0):**
```yaml
# config/routes/loevgaard_sylius_brand.yaml

loevgaard_sylius_brand:
    resource: "@LoevgaardSyliusBrandPlugin/config/routes.yaml"
```

## Step 6: Update Template Customizations

### Sonata Blocks Removed

Sonata blocks are no longer available. The plugin now uses Sylius Twig Hooks.

**Old Sonata blocks (removed):**
- `loevgaard_sylius_brand.admin.brand.create.tab_details`
- `loevgaard_sylius_brand.admin.brand.update.tab_details`
- `loevgaard_sylius_brand.admin.brand.create.tab_media`
- `loevgaard_sylius_brand.admin.brand.update.tab_media`

**New Twig Hooks:**
- `loevgaard_sylius_brand.brand.create.content.form.form_sections.general`
- `loevgaard_sylius_brand.brand.update.content.form.form_sections.general`
- `loevgaard_sylius_brand.brand.create.content.form.form_sections.media`
- `loevgaard_sylius_brand.brand.update.content.form.form_sections.media`

### Update Custom Templates

If you have customized brand templates, they need to be updated to match Sylius 2.x admin UI structure with Twig Hooks.

**Remove old template overrides:**
```bash
rm -rf templates/bundles/LoevgaardSyliusBrandPlugin/
```

Then recreate any customizations using Twig Hooks. See [Sylius Twig Hooks documentation](https://stack.sylius.com/twig-hooks/getting-started).

### Remove Product Form Customizations

The brand field is now automatically injected into the product form. Remove any manual additions:

**Remove from your templates (if present):**
```twig
{{ form_row(form.brand) }}
```

## Step 7: Update Events

The menu event has been renamed:

**Before (v2.x):**
```php
'loevgaard_sylius_brand.menu.admin.brand.form'
```

**After (v3.0):**
The admin menu is now handled via an event subscriber listening to `sylius.menu.admin.main`.

## Step 8: Clear Cache and Run Migrations

```bash
php bin/console cache:clear
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Summary of Breaking Changes

| Feature | v2.x | v3.0 |
|---------|------|------|
| PHP Version | 7.4+ | 8.2+ |
| Sylius Version | 1.x | 2.0+ |
| Symfony Version | 4.4/5.x/6.x | 6.4/7.4 |
| Product Interface | `ProductInterface` | `BrandAwareInterface` |
| Doctrine Mapping | Annotations/XML | PHP 8 Attributes (in trait) |
| Repository Extension | Required | Not needed |
| Config Import | Required | Auto-configured |
| Admin UI | Sonata Blocks | Twig Hooks |
| Resource Path | `Resources/config/` | `config/` |

## Need Help?

If you encounter issues during the upgrade, please [open an issue](https://github.com/loevgaard/SyliusBrandPlugin/issues) on GitHub.
