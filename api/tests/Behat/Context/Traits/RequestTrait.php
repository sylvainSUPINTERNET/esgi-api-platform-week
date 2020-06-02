<?php

namespace App\Tests\Behat\Context\Traits;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\Psr7\Request;

trait RequestTrait
{
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
        $this->requestPayload = $requestPayload;
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $resource)
    {
        $method = strtoupper($httpMethod);

        $options = array();

        if($this->authUser) {
            $options = ['auth' => [$this->authUser, $this->authPassword]];
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
                    'body'    => $this->requestPayload,
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
