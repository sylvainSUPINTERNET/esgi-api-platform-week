<?php

namespace App\Tests\Behat\Context\Traits;

use App\Tests\Behat\Context\ApiFeatureContext;
use App\Tests\Behat\Manager\AuthManager;
use App\Tests\Behat\Manager\ContextDataManager;
use App\Tests\Behat\Manager\FixtureManager;
use App\Tests\Behat\Manager\ReferenceManager;
use Behat\Behat\Tester\Exception\PendingException;

trait ContextDataTrait
{

    /**
     * @var ContextDataManager
     */
    private ContextDataManager $contextDataManager;

    /**
     * @var ReferenceManager
     */
    private ReferenceManager $referenceManager;

    /*
    public function saveResultInContext()
    {
        // SET FROM authManager
        //var_dump($this->contextDataManager->getValueFromState("currentUser")[0]);

        var_dump($this->printLastResponse());
        //$this->contextDataManager->addValueToState(["currentUser" => "value"]);

        /*
        var_dump($this->contextDataManager->getValueFromState("key"));
        var_dump($this->contextDataManager->getValueFromState("key2"));
        */

    /*
    }
    */

    /**
     * @Then /^save result in context as "([^"]*)"$/
     */

    // Cache data
    public function saveResultInContextAs($keyName)
    {

        var_dump("cache data with key " . $keyName);
        $data = json_decode($this->lastResponse->getContent());
        $this->referenceManager->setCachedData([$keyName=>$data]);
        var_dump(" ---- ---- ---- ---- ---- ---- ---- ---- ---- ----");
        var_dump(" ---- ---- ---- ---- ---- ---- ---- ---- ---- ----");
        var_dump(" ---- ---- ---- ---- ---- ---- ---- ---- ---- ----");
        var_dump(" ---- ---- ---- ---- ---- ---- ---- ---- ---- ----");

        //var_dump($this->referenceManager::$cachedData);

        var_dump(" ---- ---- ---- ---- ---- ---- ---- ---- ---- ----");
        var_dump(" ---- ---- ---- ---- ---- ---- ---- ---- ---- ----");
        var_dump(" ---- ---- ---- ---- ---- ---- ---- ---- ---- ----");
        var_dump(" ---- ---- ---- ---- ---- ---- ---- ---- ---- ----");


        /*
        var_dump("begin", $this->contextDataManager->getState());
        $data = json_decode($this->lastResponse->getContent());
        if($data->{'@type'} === 'hydra:Collection') {
            var_dump("saved collection");
            $this->contextDataManager->addValueToState([$keyName => $data->{"hydra:member"}]);
            //var_dump($this->contextDataManager->getState());
        } else {
            // TODO : add content (not collection) to state
            var_dump("EIAEZJAKJEé".$data);
            var_dump("HERE");
            var_dump("HERE");

        }

        //$this->contextDataManager->addValueToState([$keyName => "value"]);
        */

        //var_dump($this->referenceManager::$cachedData);

    }



}
