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


    /**
     * @Then /^save result in context as "([^"]*)"$/
     */

    // Cache data
    public function saveResultInContextAs($keyName)
    {
        $data = json_decode($this->lastResponse->getContent());
        $this->referenceManager->setCachedData([$keyName=>$data]);

    }



}
