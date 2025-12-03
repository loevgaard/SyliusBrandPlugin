<?php

declare(strict_types=1);

use Doctrine\Persistence\ManagerRegistry;
use Loevgaard\SyliusBrandPlugin\Tests\Application\Kernel;

require __DIR__ . '/../../vendor/autoload.php';

$kernel = new Kernel('test', true);
$kernel->boot();

/** @var ManagerRegistry $doctrine */
$doctrine = $kernel->getContainer()->get('doctrine');

return $doctrine->getManager();
