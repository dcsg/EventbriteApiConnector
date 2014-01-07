<?php
/**
 * This file is part of the EventbriteApiConnector package.
 *
 * (c) 2013-2014 Daniel Gomes <me@danielcsgomes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EventbriteApiConnector;

use EventbriteApiConnector\HttpAdapter\HttpAdapterInterface;

/**
 * @package EventbriteApiConnector
 *
 * @author Daniel Gomes <me@danielcsgomes.com>
 */
class Eventbrite
{
    /**
     * @var string
     * @Version Eventbrite Library version
     */
    const VERSION = '0.2.x-dev';

    /**
     * @var string
     */
    const API_ENDPOINT = '%s://www.eventbrite.com/%s/%s';

    /**
     * @var HttpAdapterInterface
     */
    private $httpAdapter;
    /**
     * @var array
     */
    private $apiKeys;
    /**
     * @var array
     */
    private $headers = array();
    /**
     * @var string
     */
    private $scheme = 'https';
    /**
     * @var string
     */
    private $outputFormat = 'json';

    /**
     * @param HttpAdapterInterface $httpAdapter HTTP Adapter
     * @param array                $apiKeys     Eventbrite API tokens to authenticate
     *
     * @throws \Exception
     */
    public function __construct(HttpAdapterInterface $httpAdapter, array $apiKeys)
    {
        if (!isset($apiKeys['app_key'])) {
            throw new \Exception('You must provide the App Key.');
        }

        $this->httpAdapter = $httpAdapter;
        $this->apiKeys = $apiKeys;
    }

    /**
     * Calls the Eventbrite API via GET
     *
     * @param string $method  Eventbrite API method
     * @param array  $params  API method params
     * @param array  $options Options for calling the API like scheme, headers and output format
     *
     * @return string The content
     */
    public function get($method, array $params, array $options = array())
    {
        $this->parseOptions($options);

        $params = array_merge($params, $this->apiKeys);

        $response = $this->httpAdapter->getContent(
            sprintf(self::API_ENDPOINT, $this->scheme, $this->outputFormat, $method .'?'. http_build_query($params)),
            $this->headers
        );

        return $this->responseHandler($response);
    }

    /**
     * Calls the Eventbrite API via POST
     *
     * @param string $method  Eventbrite API method
     * @param array  $params  API method params
     * @param array  $options Options for calling the API like scheme, headers and output format
     *
     * @return string The content
     */
    public function post($method, array $params, array $options = array())
    {
        $params = array_merge($params, $this->apiKeys);

        $this->parseOptions($options);

        $this->headers = array_merge(array('Content-type: application/x-www-form-urlencoded'), $this->headers);

        $response = $this->httpAdapter->postContent(
            sprintf(self::API_ENDPOINT, $this->scheme, $this->outputFormat, $method),
            $this->headers,
            http_build_query($params)
        );

        return $this->responseHandler($response);
    }

    /**
     * Parser for options like scheme, headers and output format.
     *
     * @param array $options
     *
     * @return null
     */
    private function parseOptions(array $options)
    {
        if (isset($options['headers']) && is_array($options['headers'])) {
            $this->headers = $options['headers'];
        }

        if (isset($options['scheme']) && strtolower($options['scheme']) === 'http') {
            $this->scheme = 'http';
        }

        if (isset($options['output_format']) && strtolower($options['output_format']) === 'xml') {
            $this->outputFormat = 'xml';
        }
    }

    /**
     * Handler for validate the response body.
     *
     * @param string $responseBody Content body of the response
     *
     * @return string
     */
    private function responseHandler($responseBody)
    {
        if ('json' === $this->outputFormat) {
            return $this->validateJsonResponse($responseBody);
        }

        return $this->validateXmlResponse($responseBody);
    }

    /**
     * Parses the response content for the JSON output format
     *
     * @param string $responseBody
     *
     * @return string
     * @throws \Exception
     */
    private function validateJsonResponse($responseBody)
    {
        $data = json_decode($responseBody);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decoding JSON.');
        }

        if (isset($data->error)) {
            throw new \Exception($data->error->error_message);
        }

        if (empty($data)) {
            throw new \Exception('No results found.');
        }

        return $responseBody;
    }

    /**
     * Parses the response content for the XML output format
     *
     * @param string $responseBody
     *
     * @return string
     * @throws \Exception
     */
    private function validateXmlResponse($responseBody)
    {
        $data = simplexml_load_string($responseBody);

        if (isset($data->error_type)) {
            throw new \Exception($data->error_message);
        }

        return $responseBody;
    }
}
