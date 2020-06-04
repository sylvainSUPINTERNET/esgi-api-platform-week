<?php

namespace App\Tests\Behat\Manager;

use ApiPlatform\Core\Api\IriConverterInterface;
use Fidry\AliceDataFixtures\Loader\PersisterLoader;
use Fidry\AliceDataFixtures\ProcessorInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class FixtureManager implements ProcessorInterface
{
    /**
     * @var PersisterLoader
     */
    private $fixtureLoader;

    /**
     * @var ReferenceManager
     */
    private $referenceManager;


    public function __construct(IriConverterInterface $iriConverter, KernelInterface $kernel, ReferenceManager $referenceManager)
    {
        $this->fixtureLoader = $kernel->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        $this->referenceManager = $referenceManager;
    }


    /**
     * Load Fixtures
     *
     * @param array $files
     */
    public function load(array $files): void
    {
        $this->fixtureLoader->load($files);

    }

    /**
     * @inheritdoc
     */
    public function preProcess(string $fixtureId, $object): void
    {
    }

    /**
     * @inheritdoc
     * @throws \Exception
     * Set the test result to cache variable for the next Scenario via preProcess
     */
    public function postProcess(string $fixtureId, $object): void
    {
        // BUILD new cache
        $this->referenceManager->addElementToNewCache([$fixtureId => $object], $fixtureId);
    }
}
