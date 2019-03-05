# UPGRADE PLUGIN FROM `v1.3.X` TO `v2.0`

The first step is upgrading Plugin with Composer

- `composer require loevgaard/sylius-brand-plugin:^2.0`

# Replace classnames

- Replace plugin's `Entity` to `Model`

# Update your `Product` entity

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
