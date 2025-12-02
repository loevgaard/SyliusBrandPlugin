<?php

declare(strict_types=1);

use Loevgaard\SyliusBrandPlugin\Tests\Application\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;

require __DIR__ . '/../../vendor/autoload.php';

$kernel = new Kernel('test', true);
$kernel->boot();

return new Application($kernel);
