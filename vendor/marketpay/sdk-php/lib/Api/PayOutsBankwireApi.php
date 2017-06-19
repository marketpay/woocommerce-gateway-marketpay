<?php
/**
 * PayOutsBankwireApi
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * MarketPay API
 *
 * API for Smart Contracts and Payments
 *
 * OpenAPI spec version: v2.01
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Api;

use \Swagger\Client\ApiClient;
use \Swagger\Client\ApiException;
use \Swagger\Client\Configuration;
use \Swagger\Client\ObjectSerializer;

/**
 * PayOutsBankwireApi Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class PayOutsBankwireApi
{
    /**
     * API Client
     *
     * @var \Swagger\Client\ApiClient instance of the ApiClient
     */
    protected $apiClient;

    /**
     * Constructor
     *
     * @param \Swagger\Client\ApiClient|null $apiClient The api client to use
     */
    public function __construct(\Swagger\Client\ApiClient $apiClient = null)
    {
        if ($apiClient === null) {
            $apiClient = new ApiClient();
        }

        $this->apiClient = $apiClient;
    }

    /**
     * Get API client
     *
     * @return \Swagger\Client\ApiClient get the API client
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Set the API client
     *
     * @param \Swagger\Client\ApiClient $apiClient set the API client
     *
     * @return PayOutsBankwireApi
     */
    public function setApiClient(\Swagger\Client\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation payOutsBankwireGet
     *
     * 
     *
     * @param int $pay_out_id  (required)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\PayOutBankwireResponse
     */
    public function payOutsBankwireGet($pay_out_id)
    {
        list($response) = $this->payOutsBankwireGetWithHttpInfo($pay_out_id);
        return $response;
    }

    /**
     * Operation payOutsBankwireGetWithHttpInfo
     *
     * 
     *
     * @param int $pay_out_id  (required)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\PayOutBankwireResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payOutsBankwireGetWithHttpInfo($pay_out_id)
    {
        // verify the required parameter 'pay_out_id' is set
        if ($pay_out_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $pay_out_id when calling payOutsBankwireGet');
        }
        // parse inputs
        $resourcePath = "/v2.01/PayOutsBankwire/bankwire/{PayOutId}";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);

        // path params
        if ($pay_out_id !== null) {
            $resourcePath = str_replace(
                "{" . "PayOutId" . "}",
                $this->apiClient->getSerializer()->toPathValue($pay_out_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\Swagger\Client\Model\PayOutBankwireResponse',
                '/v2.01/PayOutsBankwire/bankwire/{PayOutId}'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\PayOutBankwireResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\PayOutBankwireResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\CustomApiErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation payOutsBankwireGet_0
     *
     * 
     *
     * @param int $pay_out_id  (required)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\PayOutBankwireResponse
     */
    public function payOutsBankwireGet_0($pay_out_id)
    {
        list($response) = $this->payOutsBankwireGet_0WithHttpInfo($pay_out_id);
        return $response;
    }

    /**
     * Operation payOutsBankwireGet_0WithHttpInfo
     *
     * 
     *
     * @param int $pay_out_id  (required)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\PayOutBankwireResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payOutsBankwireGet_0WithHttpInfo($pay_out_id)
    {
        // verify the required parameter 'pay_out_id' is set
        if ($pay_out_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $pay_out_id when calling payOutsBankwireGet_0');
        }
        // parse inputs
        $resourcePath = "/v2.01/PayOutsBankwire/payments/{PayOutId}";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);

        // path params
        if ($pay_out_id !== null) {
            $resourcePath = str_replace(
                "{" . "PayOutId" . "}",
                $this->apiClient->getSerializer()->toPathValue($pay_out_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\Swagger\Client\Model\PayOutBankwireResponse',
                '/v2.01/PayOutsBankwire/payments/{PayOutId}'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\PayOutBankwireResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\PayOutBankwireResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\CustomApiErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation payOutsBankwirePost
     *
     * 
     *
     * @param \Swagger\Client\Model\PayOutBankwirePost $bankwire_pay_out  (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\PayOutBankwireResponse
     */
    public function payOutsBankwirePost($bankwire_pay_out = null)
    {
        list($response) = $this->payOutsBankwirePostWithHttpInfo($bankwire_pay_out);
        return $response;
    }

    /**
     * Operation payOutsBankwirePostWithHttpInfo
     *
     * 
     *
     * @param \Swagger\Client\Model\PayOutBankwirePost $bankwire_pay_out  (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\PayOutBankwireResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payOutsBankwirePostWithHttpInfo($bankwire_pay_out = null)
    {
        // parse inputs
        $resourcePath = "/v2.01/PayOutsBankwire/bankwire";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json', 'text/json', 'application/json-patch+json']);

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($bankwire_pay_out)) {
            $_tempBody = $bankwire_pay_out;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\Swagger\Client\Model\PayOutBankwireResponse',
                '/v2.01/PayOutsBankwire/bankwire'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\PayOutBankwireResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\PayOutBankwireResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\CustomApiErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation payOutsBankwirePost_0
     *
     * 
     *
     * @param \Swagger\Client\Model\PayOutBankwirePost $bankwire_pay_out  (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\PayOutBankwireResponse
     */
    public function payOutsBankwirePost_0($bankwire_pay_out = null)
    {
        list($response) = $this->payOutsBankwirePost_0WithHttpInfo($bankwire_pay_out);
        return $response;
    }

    /**
     * Operation payOutsBankwirePost_0WithHttpInfo
     *
     * 
     *
     * @param \Swagger\Client\Model\PayOutBankwirePost $bankwire_pay_out  (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\PayOutBankwireResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payOutsBankwirePost_0WithHttpInfo($bankwire_pay_out = null)
    {
        // parse inputs
        $resourcePath = "/v2.01/PayOutsBankwire/payments/direct";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json', 'text/json', 'application/json-patch+json']);

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($bankwire_pay_out)) {
            $_tempBody = $bankwire_pay_out;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\Swagger\Client\Model\PayOutBankwireResponse',
                '/v2.01/PayOutsBankwire/payments/direct'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\PayOutBankwireResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\PayOutBankwireResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\CustomApiErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }
}
