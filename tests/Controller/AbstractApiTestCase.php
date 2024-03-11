<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Tests\Controller;

use ApiTestCase\JsonApiTestCase;
use ApiTestCase\PathBuilder;

abstract class AbstractApiTestCase extends JsonApiTestCase
{
    protected array $defaultFixtureFiles = [];

    protected static array $headerWithContentType = [
        'CONTENT_TYPE' => 'application/json',
    ];

    protected static array $authorizedHeaderWithContentType = [
        'HTTP_Authorization' => 'Bearer SampleTokenNjZkNjY2MDEwMTAzMDkxMGE0OTlhYzU3NzYyMTE0ZGQ3ODcyMDAwM2EwMDZjNDI5NDlhMDdlMQ',
        'CONTENT_TYPE' => 'application/json',
    ];

    protected static array $authorizedHeaderWithAccept = [
        'HTTP_Authorization' => 'Bearer SampleTokenNjZkNjY2MDEwMTAzMDkxMGE0OTlhYzU3NzYyMTE0ZGQ3ODcyMDAwM2EwMDZjNDI5NDlhMDdlMQ',
        'ACCEPT' => 'application/json',
    ];

    protected function loadDefaultFixtureFiles(array $additionalFixtureFiles = []): array
    {
        $fixtureFiles = array_merge(
            $this->defaultFixtureFiles,
            $additionalFixtureFiles,
        );

        $entities = [];

        foreach ($fixtureFiles as $fixtureFile) {
            $entities[] = $this->loadFixturesFromFile($fixtureFile);
        }

        return array_merge(...$entities);
    }

    private function getFixtureRealPath(string $source): string
    {
        $baseDirectory = $this->getFixturesFolder();

        return PathBuilder::build($baseDirectory, $source);
    }

    private function getCalledClassFolder(): string
    {
        $calledClass = static::class;
        $calledClassFolder = dirname((new \ReflectionClass($calledClass))->getFileName());

        $this->assertSourceExists($calledClassFolder);

        return $calledClassFolder;
    }

    private function assertSourceExists(string $source): void
    {
        if (!file_exists($source)) {
            throw new \RuntimeException(sprintf('File %s does not exist', $source));
        }
    }

    private function getRootDir(): string
    {
        return $this->get('kernel')->getRootDir();
    }

    private function getFixturesFolder(): string
    {
        if (null === $this->dataFixturesPath) {
            $this->dataFixturesPath = isset($_SERVER['FIXTURES_DIR']) ?
                PathBuilder::build($this->getRootDir(), $_SERVER['FIXTURES_DIR']) :
                PathBuilder::build($this->getCalledClassFolder(), '..', 'DataFixtures', 'ORM');
        }

        return $this->dataFixturesPath;
    }
}
