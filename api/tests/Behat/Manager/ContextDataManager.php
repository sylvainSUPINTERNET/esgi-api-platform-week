<?php

namespace App\Tests\Behat\Manager;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Fidry\AliceDataFixtures\Loader\PersisterLoader;
use Fidry\AliceDataFixtures\ProcessorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ContextDataManager implements ProcessorInterface
{
    /**
     * @var PersisterLoader
     */
    private $fixtureLoader;
    private $fixtureManager;
    private $em;
    private $referenceManager;

    public $state = [];


    public function __construct(IriConverterInterface $iriConverter, KernelInterface $kernel, FixtureManager $fixtureManager,JWTTokenManagerInterface $JWTManager, EntityManagerInterface $entityManager, ReferenceManager $referenceManager)
    {
        $this->fixtureLoader = $kernel->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        $this->fixtureManager = $fixtureManager;
        $this->em = $entityManager;
        $this->referenceManager = $referenceManager;
    }

    public function addValueToState($object){ // object key -> val

        $keyFixtureLoaded = array_keys($object)[0];

        if(sizeof($this->state) === 0) {
            array_push($this->state, $object);
        } else {
            $fl = true;
            foreach($this->state as $arr) {
                foreach($arr as $key=>$value) {
                    if($keyFixtureLoaded === $key && $keyFixtureLoaded !== "currentUser") {
                        $lf=false;
                    }
                }
            }

            if($fl===true) {
                array_push($this->state, $object);
            }
            var_dump("update state")
;        }
    }

    public function getValueFromState($keyName) {
        foreach ($this->state as $array) {
            foreach ($array as $key=>$value) {
                if($key === $keyName) {
                    return $value;
                }
            }
        }
    }

    public function getState() {
        return $this->state;
    }


    public function preProcess(string $fixtureId, $object): void
    {
    }

    public function postProcess(string $fixtureId, $object): void
    {
    }



}
