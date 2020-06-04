<?php

namespace App\Tests\Behat\Context\Traits;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Tests\Behat\Manager\AuthManager;
use App\Tests\Behat\Manager\FixtureManager;
use App\Tests\Behat\Manager\ReferenceManager;
use App\Tests\Behat\Manager\RequestManager;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Psr7\Request;

trait RequestTrait
{
    /**
     * @var AuthManager
     */
    private AuthManager $authManger;

    /**
     * @var RequestManager
     */
    private RequestManager $requestManager;

    /**
     * @var FixtureManager
     */
    private FixtureManager $fixtureManager;

    /**
     * @var ReferenceManager
     */
    private ReferenceManager $referenceManager;

    /**
     * Payload of the request
     *
     * @var string
     */
    protected $requestPayload;

    /**
     * Payload of the response
     *
     * @var string
     */
    protected $responsePayload;

    /**
     * The Guzzle client
     *
     * @var Client
     */
    protected $client;

    /**
     * The response of the HTTP request
     *
     * @var \Symfony\Contracts\HttpClient\ResponseInterface
     */
    protected $lastResponse;

    /**
     * Headers sent with request
     *
     * @var array[]
     */
    protected $requestHeaders = array();

    /**
     * The last request that was used to make the response
     *
     * @var
     */
    protected $lastRequest;

    /**
     * @Given I have the payload
     */
    public function iHaveThePayload(PyStringNode $requestPayload)
    {
        $this->requestPayload = json_decode($requestPayload->getRaw());
    }


    /**
     * @When /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $resource)
    {

        $method = strtoupper($httpMethod);

        if($this->authManager->getAccessToken()) {
            $this->requestHeaders = array(
                "Content-type" => "application/ld+json",
                "Authorization" => "Bearer " . $this->authManager->getAccessToken()
            );
        }

        $this->lastRequest = new Request(
            $httpMethod,
            $resource,
            $this->requestHeaders,
            json_encode($this->requestPayload)
        );

        try {
            // Send request
            $this->lastResponse = $this->client->request(
                $method,
                $resource,
                [
                    'headers' => $this->requestHeaders,
                    'body'    => json_encode($this->requestPayload),
                ]
            );

        } catch (\Exception $e) {
            $response = $e->getMessage();

            if ($response === null) {
                throw $e;
            }

            $this->lastResponse = $e->getMessage();
            throw new \Exception('Bad response.');
        }
    }

    /**
     * Set before send request
     *
     * @Given /^I set the "([^"]*)" header to be "([^"]*)"$/
     */
    public function iSetTheHeaderToBe($headerName, $value)
    {
        $this->requestHeaders[$headerName] = $value;
    }

    /**
     * Test header after request
     *
     * @Given /^the "([^"]*)" header should be "([^"]*)"$/
     */
    public function theHeaderShouldBe($headerName, $expectedHeaderValue)
    {
        $response = $this->getLastResponse();

        assertEquals($expectedHeaderValue, (string) $response->getHeader($headerName));
    }

    /**
     * Test header after request
     *
     * @Given /^the "([^"]*)" header should exist$/
     */
    public function theHeaderShouldExist($headerName)
    {
        $response = $this->getLastResponse();

        assertTrue($response->hasHeader($headerName));
    }

    /**
     * Test status code after request
     *
     * @Then /^the response status code should be (?P<code>\d+)$/
     */
    public function theResponseStatusCodeShouldBe($statusCode)
    {
        $response = $this->getLastResponse();

        assertEquals($statusCode,
            $response->getStatusCode(),
            sprintf('Expected status code "%s" does not match observed status code "%s"', $statusCode, $response->getStatusCode()));
    }

    /**
     * Checks the response exists and returns it.
     *
     * @return \Symfony\Contracts\HttpClient\ResponseInterface
     * @throws \Exception
     */
    protected function getLastResponse()
    {
        if (! $this->lastResponse) {
            throw new \Exception("You must first make a request to check a response.");
        }

        return $this->lastResponse;
    }



    // deprecated
    /**
     * @Then /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)" with context "([^"]*)"$/
     */
    public function iRequestWithContext($httpMethod, $resource, $property)
    {
        $cached = $this->referenceManager::$cachedData; // array on $data->{"hydra:member"}

        $correctKey = "";
        $correctPosition = "";
        foreach($cached as $key=>$value) {
            foreach($cached[$key] as $k=>$v) {
               /* var_dump(":::::::::::::::::::::::::::::::::::::::::::::");
                var_dump("correctk key name", $k);
                var_dump("correctk position", $key);
                var_dump(":::::::::::::::::::::::::::::::::::::::::::::");*/
                if(str_replace('/', '', $resource) === $k) {
                    $correctKey = $k;
                    $correctPosition = $key;
                }
            }
        }

        //var_dump($cached);
        //var_dump($cached->{"hydra:member"}[0]->{$property});
        //var_dump($resource);

        $method = strtoupper($httpMethod);

        if($this->authManager->getAccessToken()) {
            $this->requestHeaders = array(
                "Content-type" => "application/ld+json",
                "Authorization" => "Bearer " . $this->authManager->getAccessToken()
            );
        }

        $this->lastRequest = new Request(
            $httpMethod,
            // get the correct key
            // 2 behaviors (currentUser is not list)
            // for list by default take the first element
            $correctKey === "currentUser" ? $cached[$correctPosition][$correctKey][0]->{"id"} : $cached[$correctPosition][$correctKey]->{"hydra:member"}[0]->{$property},
            $this->requestHeaders,
            json_encode($this->requestPayload)
        );


        try {
            // Send request
            $this->lastResponse = $this->client->request(
                $method,
                $resource,
                [
                    'headers' => $this->requestHeaders,
                    'body'    => json_encode($this->requestPayload),
                ]
            );

        } catch (\Exception $e) {
            $response = $e->getMessage();

            if ($response === null) {
                throw $e;
            }

            $this->lastResponse = $e->getMessage();
            throw new \Exception('Bad response.');
        }
    }

    // deprecated
    /**
     * @Then /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)" with context body "([^"]*)"$/
     */
    public function iRequestWithContextBody($httpVerb,$resource, $body)
    {
        $cached = $this->referenceManager::$cachedData; // array on $data->{"hydra:member"}

        $properties = explode(' ', $body);
        $method = strtoupper($httpVerb);

        $map = [];

        foreach($properties as $property) {
            $search = $property === "user" ? "currentUser" : $property;

            $correctKey = "";
            $correctPosition = "";
            $mapValue = [];
            foreach($cached as $key=>$value) {
                foreach($cached[$key] as $k=>$v) {

                    if($search === $k) {
                        $correctKey = $k;
                        $correctPosition = $key;

                        array_push($map, [$property => $correctKey === "currentUser" ?
                            "/users/".$cached[$correctPosition][$correctKey][0]->{"id"}
                            : $correctKey."/".$cached[$correctPosition][$correctKey]->{"hydra:member"}[0]->{"@id"}]);
                    }
                }
            }
        }


        if($this->authManager->getAccessToken()) {
            $this->requestHeaders = array(
                "Content-type" => "application/ld+json",
                "Authorization" => "Bearer " . $this->authManager->getAccessToken()
            );
        }

        // FOR each json element where the key is contains in search array, replace the value by the map value
        foreach($this->requestPayload as $key=>$element) {
            //var_dump($key . " : " . $element);
            foreach($map as $km=>$vm) {
                foreach($vm as $ak => $av) {
                    if($ak === $key) {
                        $this->requestPayload->{$ak} = $av;
                    }
                }
            }
        }

        //var_dump($this->referenceManager::$cachedData);
        $this->lastRequest = new Request(
            $httpVerb,
            // get the correct key
            // 2 behaviors (currentUser is not list)
            // for list by default take the first element
        "/",
            $this->requestHeaders,
            json_encode($this->requestPayload)
        );


        try {
            // Send request
            $this->lastResponse = $this->client->request(
                $method,
                $resource,
                [
                    'headers' => $this->requestHeaders,
                    'body'    => json_encode($this->requestPayload),
                ]
            );

        } catch (\Exception $e) {
            $response = $e->getMessage();

            if ($response === null) {
                throw $e;
            }

            $this->lastResponse = $e->getMessage();
            throw new \Exception('Bad response.');
        }

    }

    /**
     * @Then /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)" with fields "([^"]*)" equal "([^"]*)"$/
     * @param $payloadField -> field name to find in the json and set the value with the iri build from $propertiesToLink
     * @param $propertiesToLink -> value1=value2 ---> value1 is the iri name like /users and value2 is the key to find the value
     */
    public function iRequestWithData($method, $resource, $payloadFields,$propertiesToLink)
    {
        $method = strtoupper($method);
        if($this->authManager->getAccessToken()) {
            $this->requestHeaders = array(
                "Content-type" => "application/ld+json",
                "Authorization" => "Bearer " . $this->authManager->getAccessToken()
            );
        }
        $payloadFieldsArray = explode(' ', $payloadFields);
        $properties = explode(' ', $propertiesToLink);
        $listProps = []; // contains value for iri /$uriLinkedProps/<here>
        $uriLinkedProps = []; // contains value to make the iri /<here>

        $linkFieldWithCacheKeyName = [];
        $linkforIri = [];

        foreach($properties as $key=>$prop){
            array_push($uriLinkedProps, explode('=', $prop)[0]);
            array_push($listProps, explode('=', $prop)[1]);
            foreach($payloadFieldsArray as $field) {
                array_push($linkforIri, [explode('=', $prop)[0]=> $field ]);
                array_push($linkFieldWithCacheKeyName, [explode('=', $prop)[1]=> $field ]);
            }
        }

        //var_dump($this->referenceManager::$newCache);

        $possibleValue = [];
        foreach ($listProps as $val) {
            var_dump($val);
            array_push($possibleValue, [$val => array()] );
        }

        foreach($this->referenceManager::$newCache as $key=>$cachedValue) {
            foreach($cachedValue as $keyb=>$obj){
                //var_dump("keyb" . $keyb);
                //var_dump($keyb . " : " . $obj->{"id"});
                foreach($listProps as $val) {
                   if($val === $keyb) {
                       //var_dump($possibleValue[0][$keyb]);
                       array_push($possibleValue[0][$keyb], $obj->{"id"});
                   }
                }
            }
        }

        //var_dump("possible", $possibleValue);


        //var_dump($this->referenceManager::$newCache);


        foreach($this->requestPayload as $key=>$element) {

            foreach($linkFieldWithCacheKeyName as $k=>$val) {
                foreach($val as $l=>$y){
                    foreach($linkforIri as $k2=>$v2) {
                        foreach($v2 as $x=>$o){
                            if($y == $key){
                                $this->requestPayload->{$key} = "/".$x."/".end($possibleValue[0][$l]);
                            }
                        }

                    }

                }
            }
        }

        var_dump($this->requestPayload);



        $this->lastRequest = new Request(
            $method,
            $resource,
            $this->requestHeaders,
            json_encode($this->requestPayload)
        );


        try {
            // Send request
            $this->lastResponse = $this->client->request(
                $method,
                $resource,
                [
                    'headers' => $this->requestHeaders,
                    'body'    => json_encode($this->requestPayload),
                ]
            );

        } catch (\Exception $e) {
            $response = $e->getMessage();

            if ($response === null) {
                throw $e;
            }

            $this->lastResponse = $e->getMessage();
            throw new \Exception('Bad response.');
        }

    }


    /**
     * Return the response payload from the current response.
     *
     * @return mixed|string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function getResponsePayload()
    {
        $json = json_decode($this->getLastResponse()->getContent(false));
        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = 'Failed to decode JSON body ';

            switch (json_last_error()) {
                case JSON_ERROR_DEPTH:
                    $message .= '(Maximum stack depth exceeded).';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $message .= '(Underflow or the modes mismatch).';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $message .= '(Unexpected control character found).';
                    break;
                case JSON_ERROR_SYNTAX:
                    $message .= '(Syntax error, malformed JSON): ' . "\n\n" . $this->getLastResponse()->getContent(false);
                    break;
                case JSON_ERROR_UTF8:
                    $message .= '(Malformed UTF-8 characters, possibly incorrectly encoded).';
                    break;
                default:
                    $message .= '(Unknown error).';
                    break;
            }

            throw new \Exception($message);
        }

        $this->responsePayload = $json;
        return $this->responsePayload;
    }


    /**
     * Returns the payload from the current scope within
     * the response.
     *
     * @return mixed
     */
    protected function getScopePayload()
    {
        $payload = $this->getResponsePayload();

        if (! $this->scope) {
            return $payload;
        }

        return $this->arrayGet($payload, $this->scope, true);
    }
}
