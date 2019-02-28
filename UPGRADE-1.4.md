# UPGRADE PLUGIN FROM `v1.3.X` TO `v1.4.0`

The first step is upgrading Plugin with Composer

- `composer require loevgaard/sylius-brand-plugin:~1.4.0`

# Update your `Product` entity

`Product`` now should implement `Loevgaard\SyliusBrandPlugin\Entity\ProductInterface`
rather than just `Loevgaard\SyliusBrandPlugin\Entity\BrandAwareInterface`:

```php
<?php
// src/Entity/Product.php

declare(strict_types=1);

namespace App\Entity;

use Loevgaard\SyliusBrandPlugin\Entity\ProductTrait;
use Loevgaard\SyliusBrandPlugin\Entity\ProductInterface as LoevgaardSyliusBrandPluginProductInterface;
use Sylius\Component\Core\Model\Product as BaseProduct;

// ...
class Product extends BaseProduct implements LoevgaardSyliusBrandPluginProductInterface
{
    use ProductTrait;
    
    // ...
}
```
