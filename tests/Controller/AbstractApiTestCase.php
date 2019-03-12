<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBrandPlugin\Controller;

use Lakion\ApiTestCase\JsonApiTestCase;
use Lakion\ApiTestCase\PathBuilder;

abstract class AbstractApiTestCase extends JsonApiTestCase
{
    protected $defaultFixtureFiles = [];

    /** @var array */
    protected static $headerWithContentType = [
        'CONTENT_TYPE' => 'application/json',
    ];

    /** @var array */
    protected static $authorizedHeaderWithContentType = [
        'HTTP_Authorization' => 'Bearer SampleTokenNjZkNjY2MDEwMTAzMDkxMGE0OTlhYzU3NzYyMTE0ZGQ3ODcyMDAwM2EwMDZjNDI5NDlhMDdlMQ',
        'CONTENT_TYPE' => 'application/json',
    ];

    /** @var array */
    protected static $authorizedHeaderWithAccept = [
        'HTTP_Authorization' => 'Bearer SampleTokenNjZkNjY2MDEwMTAzMDkxMGE0OTlhYzU3NzYyMTE0ZGQ3ODcyMDAwM2EwMDZjNDI5NDlhMDdlMQ',
        'ACCEPT' => 'application/json',
    ];

    /**
     * @param array $additionalFixtureFiles
     * @return array
     */
    protected function loadDefaultFixtureFiles(array $additionalFixtureFiles = [])
    {
        return $this->loadFixturesFromFile(
            array_merge(
                $this->defaultFixtureFiles,
                $additionalFixtureFiles
            )
        );
    }

    /**
     * Support loading array of fixtures files
     *
     * @param string|array $source
     *
     * @return array
     */
    protected function loadFixturesFromFile($source)
    {
        if (!is_array($source)) {
            $source = [$source];
        }

        $source = array_map(function($filename){
            $filename = $this->getFixtureRealPath($filename);
            $this->assertSourceExists($filename);

            return $filename;
        }, $source);

        return $this->getFixtureLoader()->load($source, [
            'persist_once'=>false
        ]);
    }

    /**
     * @param string $source
     *
     * @return string
     */
    private function getFixtureRealPath($source)
    {
        $baseDirectory = $this->getFixturesFolder();

        return PathBuilder::build($baseDirectory, $source);
    }

    /**
     * @return string
     */
    private function getCalledClassFolder()
    {
        $calledClass = get_called_class();
        $calledClassFolder = dirname((new \ReflectionClass($calledClass))->getFileName());

        $this->assertSourceExists($calledClassFolder);

        return $calledClassFolder;
    }

    /**
     * @param string $source
     */
    private function assertSourceExists($source)
    {
        if (!file_exists($source)) {
            throw new \RuntimeException(sprintf('File %s does not exist', $source));
        }
    }

    /**
     * @return string
     */
    private function getRootDir()
    {
        return $this->get('kernel')->getRootDir();
    }

    /**
     * @return string
     */
    private function getFixturesFolder()
    {
        if (null === $this->dataFixturesPath) {
            $this->dataFixturesPath = isset($_SERVER['FIXTURES_DIR']) ?
                PathBuilder::build($this->getRootDir(), $_SERVER['FIXTURES_DIR'] ) :
                PathBuilder::build($this->getCalledClassFolder(), '..', 'DataFixtures', 'ORM');
        }

        return $this->dataFixturesPath;
    }
}
