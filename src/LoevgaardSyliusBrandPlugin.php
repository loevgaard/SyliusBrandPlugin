<?php

/** @noinspection TraitsPropertiesConflictsInspection */

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class LoevgaardSyliusBrandPlugin extends Bundle
{
    use SyliusPluginTrait;
}
