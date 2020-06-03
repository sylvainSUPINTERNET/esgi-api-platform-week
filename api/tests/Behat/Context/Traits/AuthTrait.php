<?php

namespace App\Tests\Behat\Context\Traits;

use App\Tests\Behat\Context\ApiFeatureContext;
use App\Tests\Behat\Manager\AuthManager;
use App\Tests\Behat\Manager\FixtureManager;
use Behat\Behat\Tester\Exception\PendingException;

trait AuthTrait
{
    /**
     * The user to use with HTTP basic authentication
     *
     * @var string
     */
    protected $authUser;

    /**
     * The password to use with HTTP basic authentication
     *
     * @var string
     */
    protected $authPassword;

    /**
     * @var AuthManager
     */
    private AuthManager $authManager;

    /**
     * @var ApiFeatureContext
     */
    private ApiFeatureContext $apiFeatureContext;

    private string $jwt;

    /**
     * @Given /^I authenticate with user "([^"]*)" and password "([^"]*)"$/
     */
    public function iAuthenticateWithEmailAndPassword($email, $password)
    {
        $this->jwt = $this->authManager->generateAccessToken($email, $password);
        $this->authUser = $email;
        $this->authPassword = $password;
    }



}
