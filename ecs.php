<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $config): void {
    $config->import('vendor/sylius-labs/coding-standard/ecs.php');
    $config->paths([
        'config',
        'src',
        'tests',
    ]);
    $config->skip([
        'tests/Application/config/reference.php',
        'tests/Application/node_modules/**',
        'tests/Application/var/**',
    ]);
};
