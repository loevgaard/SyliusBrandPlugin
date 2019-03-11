# UPGRADE PLUGIN 

## FROM `v1.3.X` TO `v2.0`

The first step is upgrading Plugin with Composer

- `composer require loevgaard/sylius-brand-plugin:^2.0`

### Replace classnames

- Replace plugin's `Entity` to `Model` with your editor's
  Find & Replace function 
  (in case you used them somewhere in your application):
  
  `Loevgaard\SyliusBrandPlugin\Entity` > `Loevgaard\SyliusBrandPlugin\Model`

### Replace imported config

- Import `config/app/config.yml` rather than `config/config.yml` (which no longer exists)

  `- { resource: "@LoevgaardSyliusBrandPlugin/Resources/config/config.yml" }` > `- { resource: "@LoevgaardSyliusBrandPlugin/Resources/config/app/config.yml" }`

### Add new (optional) config 

If you wish to display Brand column at Product list grid (`sylius_admin_product`) at Admin:

```yaml
# src/config/services.yaml
imports:
    # ...
    - { resource: "@LoevgaardSyliusBrandPlugin/Resources/config/grids/sylius_admin_product.yml" }
``` 

### Update your `Product` entity

`Product` now should implement `Loevgaard\SyliusBrandPlugin\Model\ProductInterface`
rather than just `Loevgaard\SyliusBrandPlugin\Model\BrandAwareInterface`:

```php
<?php
// src/Model/Product.php

declare(strict_types=1);

namespace App\Model;

use Loevgaard\SyliusBrandPlugin\Model\ProductTrait;
use Loevgaard\SyliusBrandPlugin\Model\ProductInterface as LoevgaardSyliusBrandPluginProductInterface;
use Sylius\Component\Core\Model\Product as BaseProduct;

// ...
class Product extends BaseProduct implements LoevgaardSyliusBrandPluginProductInterface
{
    use ProductTrait;
    
    // ...
}
```

### Migrate

- Copy migration files to your app's migrations directory:

  ```bash
  cp vendor/loevgaard/sylius-brand-plugin/tests/Application/DoctrineMigrations/*.php src/Migrations/
  ``` 
  
  Where `src/Migrations` is your app's migrations directory.

- Run one or two migrations

    ```bash
    # Define database name at env variable for easier usage
    DATABASE_NAME=sylius_brand_plugin_dev
    
    # Check what we have initially
    $ mysql $DATABASE_NAME -e "select * from loevgaard_brand"
    +----+--------+--------+
    | id | slug   | name   |
    +----+--------+--------+
    |  1 | setono | Setono |
    |  2 | sylius | Sylius |
    +----+--------+--------+
    
    # Run first migration to 
    # add new code field to brand, copy slug to code, make code unique
    $ bin/console doctrine:migration:execute 20190311083224 --no-interaction
    
      ++ migrating 20190311083224
    
         -> DROP INDEX UNIQ_680CAA08989D9B62 ON loevgaard_brand
         -> ALTER TABLE loevgaard_brand ADD code VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL
         -> UPDATE loevgaard_brand SET code = slug
         -> CREATE UNIQUE INDEX UNIQ_680CAA0877153098 ON loevgaard_brand (code)
    
      ++ migrated (took 224.8ms, used 32.25M memory)
    
    # Check slug copied to code properly
    $ mysql $DATABASE_NAME -e "select * from loevgaard_brand"
    +----+--------+--------+--------+
    | id | slug   | name   | code   |
    +----+--------+--------+--------+
    |  1 | setono | Setono | setono |
    |  2 | sylius | Sylius | sylius |
    +----+--------+--------+--------+
    
    # (optional) Run another one to
    # remove old slug column from database
    # WARNING! Do this only AFTER you sure slug copied to code field properly
    $ bin/console doctrine:migration:execute 20190311083313 --no-interaction
    
      ++ migrating 20190311083313
    
         -> ALTER TABLE loevgaard_brand DROP slug
    
      ++ migrated (took 170.3ms, used 32.25M memory)
    
    # Check slug field removed
    $ mysql $DATABASE_NAME -e "select * from loevgaard_brand"
    +----+--------+--------+
    | id | name   | code   |
    +----+--------+--------+
    |  1 | Setono | setono |
    |  2 | Sylius | sylius |
    +----+--------+--------+
    ```
