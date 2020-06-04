<?php

namespace App\Tests\Behat\Manager;

use ApiPlatform\Core\Api\IriConverterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Fidry\AliceDataFixtures\Loader\PersisterLoader;
use Fidry\AliceDataFixtures\ProcessorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class RequestManager implements ProcessorInterface
{
    /**
     * @var PersisterLoader
     */
    private $em;
    private $fixtureLoader;
    private $fixtureManager;

    public function __construct(IriConverterInterface $iriConverter, KernelInterface $kernel, FixtureManager $fixtureManager, EntityManagerInterface $entityManager){
        $this->fixtureLoader = $kernel->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        $this->fixtureManager = $fixtureManager;
        $this->em = $entityManager;
    }

    public function preProcess(string $id, $object): void
    {
        // TODO: Implement preProcess() method.
    }

    public function postProcess(string $id, $object): void
    {
        // TODO: Implement postProcess() method.
    }
}
