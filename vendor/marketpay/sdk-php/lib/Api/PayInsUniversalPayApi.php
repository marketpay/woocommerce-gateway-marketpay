<?php
/**
 * PayInsUniversalPayApi
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
 * PayInsUniversalPayApi Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class PayInsUniversalPayApi
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
     * @return PayInsUniversalPayApi
     */
    public function setApiClient(\Swagger\Client\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation payInsUniversalPayGetUniversalPayTokenization
     *
     * View a UniversalPay card tokenization status
     *
     * @param int $token_id The Id of a tokenization (required)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\UniversalPayTokenizationResponse
     */
    public function payInsUniversalPayGetUniversalPayTokenization($token_id)
    {
        list($response) = $this->payInsUniversalPayGetUniversalPayTokenizationWithHttpInfo($token_id);
        return $response;
    }

    /**
     * Operation payInsUniversalPayGetUniversalPayTokenizationWithHttpInfo
     *
     * View a UniversalPay card tokenization status
     *
     * @param int $token_id The Id of a tokenization (required)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\UniversalPayTokenizationResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payInsUniversalPayGetUniversalPayTokenizationWithHttpInfo($token_id)
    {
        // verify the required parameter 'token_id' is set
        if ($token_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $token_id when calling payInsUniversalPayGetUniversalPayTokenization');
        }
        // parse inputs
        $resourcePath = "/v2.01/PayInsUniversalPay/token/{TokenId}";
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
        if ($token_id !== null) {
            $resourcePath = str_replace(
                "{" . "TokenId" . "}",
                $this->apiClient->getSerializer()->toPathValue($token_id),
                $resourcePath
            );
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
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\Swagger\Client\Model\UniversalPayTokenizationResponse',
                '/v2.01/PayInsUniversalPay/token/{TokenId}'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\UniversalPayTokenizationResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\UniversalPayTokenizationResponse', $e->getResponseHeaders());
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
     * Operation payInsUniversalPayUniversalPayGetPayment
     *
     * View a UniversalPay payment
     *
     * @param int $pay_in_id The Id of a payment (required)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\UniversalPayPayInsResponse
     */
    public function payInsUniversalPayUniversalPayGetPayment($pay_in_id)
    {
        list($response) = $this->payInsUniversalPayUniversalPayGetPaymentWithHttpInfo($pay_in_id);
        return $response;
    }

    /**
     * Operation payInsUniversalPayUniversalPayGetPaymentWithHttpInfo
     *
     * View a UniversalPay payment
     *
     * @param int $pay_in_id The Id of a payment (required)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\UniversalPayPayInsResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payInsUniversalPayUniversalPayGetPaymentWithHttpInfo($pay_in_id)
    {
        // verify the required parameter 'pay_in_id' is set
        if ($pay_in_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $pay_in_id when calling payInsUniversalPayUniversalPayGetPayment');
        }
        // parse inputs
        $resourcePath = "/v2.01/PayInsUniversalPay/payments/{PayInId}";
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
        if ($pay_in_id !== null) {
            $resourcePath = str_replace(
                "{" . "PayInId" . "}",
                $this->apiClient->getSerializer()->toPathValue($pay_in_id),
                $resourcePath
            );
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
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\Swagger\Client\Model\UniversalPayPayInsResponse',
                '/v2.01/PayInsUniversalPay/payments/{PayInId}'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\UniversalPayPayInsResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\UniversalPayPayInsResponse', $e->getResponseHeaders());
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
     * Operation payInsUniversalPayUniversalPayPostPaymentByWeb
     *
     * Create a UniversalPay PayIn Request
     *
     * @param \Swagger\Client\Model\UniversalPayPayByWebPost $universal_pay_pay_in UniversalPay PayIn Request Object params (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\UniversalPayPayByWebResponse
     */
    public function payInsUniversalPayUniversalPayPostPaymentByWeb($universal_pay_pay_in = null)
    {
        list($response) = $this->payInsUniversalPayUniversalPayPostPaymentByWebWithHttpInfo($universal_pay_pay_in);
        return $response;
    }

    /**
     * Operation payInsUniversalPayUniversalPayPostPaymentByWebWithHttpInfo
     *
     * Create a UniversalPay PayIn Request
     *
     * @param \Swagger\Client\Model\UniversalPayPayByWebPost $universal_pay_pay_in UniversalPay PayIn Request Object params (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\UniversalPayPayByWebResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payInsUniversalPayUniversalPayPostPaymentByWebWithHttpInfo($universal_pay_pay_in = null)
    {
        // parse inputs
        $resourcePath = "/v2.01/PayInsUniversalPay/payments/web";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json-patch+json', 'application/json', 'text/json', 'application/_*+json']);

        // body params
        $_tempBody = null;
        if (isset($universal_pay_pay_in)) {
            $_tempBody = $universal_pay_pay_in;
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
                '\Swagger\Client\Model\UniversalPayPayByWebResponse',
                '/v2.01/PayInsUniversalPay/payments/web'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\UniversalPayPayByWebResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\UniversalPayPayByWebResponse', $e->getResponseHeaders());
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
     * Operation payInsUniversalPayUniversalPayPostRefund
     *
     * Create a UniversalPay Payment Refund
     *
     * @param int $pay_in_id The Id of a PayIn (required)
     * @param \Swagger\Client\Model\UniversalPayRefundPost $universal_pay_refund Refund Object params (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\UniversalPayRefundResponse
     */
    public function payInsUniversalPayUniversalPayPostRefund($pay_in_id, $universal_pay_refund = null)
    {
        list($response) = $this->payInsUniversalPayUniversalPayPostRefundWithHttpInfo($pay_in_id, $universal_pay_refund);
        return $response;
    }

    /**
     * Operation payInsUniversalPayUniversalPayPostRefundWithHttpInfo
     *
     * Create a UniversalPay Payment Refund
     *
     * @param int $pay_in_id The Id of a PayIn (required)
     * @param \Swagger\Client\Model\UniversalPayRefundPost $universal_pay_refund Refund Object params (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\UniversalPayRefundResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payInsUniversalPayUniversalPayPostRefundWithHttpInfo($pay_in_id, $universal_pay_refund = null)
    {
        // verify the required parameter 'pay_in_id' is set
        if ($pay_in_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $pay_in_id when calling payInsUniversalPayUniversalPayPostRefund');
        }
        // parse inputs
        $resourcePath = "/v2.01/PayInsUniversalPay/payments/{PayInId}/refunds";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json-patch+json', 'application/json', 'text/json', 'application/_*+json']);

        // path params
        if ($pay_in_id !== null) {
            $resourcePath = str_replace(
                "{" . "PayInId" . "}",
                $this->apiClient->getSerializer()->toPathValue($pay_in_id),
                $resourcePath
            );
        }
        // body params
        $_tempBody = null;
        if (isset($universal_pay_refund)) {
            $_tempBody = $universal_pay_refund;
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
                '\Swagger\Client\Model\UniversalPayRefundResponse',
                '/v2.01/PayInsUniversalPay/payments/{PayInId}/refunds'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\UniversalPayRefundResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\UniversalPayRefundResponse', $e->getResponseHeaders());
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
     * Operation payInsUniversalPayUniversalPaySaveCard
     *
     * @param \Swagger\Client\Model\UniversalPayTokenRequestPost $universal_pay_save_card  (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return \Swagger\Client\Model\UniversalPayTokenizeByWebResponse
     */
    public function payInsUniversalPayUniversalPaySaveCard($universal_pay_save_card = null)
    {
        list($response) = $this->payInsUniversalPayUniversalPaySaveCardWithHttpInfo($universal_pay_save_card);
        return $response;
    }

    /**
     * Operation payInsUniversalPayUniversalPaySaveCardWithHttpInfo
     *
     * @param \Swagger\Client\Model\UniversalPayTokenRequestPost $universal_pay_save_card  (optional)
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @return array of \Swagger\Client\Model\UniversalPayTokenizeByWebResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function payInsUniversalPayUniversalPaySaveCardWithHttpInfo($universal_pay_save_card = null)
    {
        // parse inputs
        $resourcePath = "/v2.01/PayInsUniversalPay/token/web";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json-patch+json', 'application/json', 'text/json', 'application/_*+json']);

        // body params
        $_tempBody = null;
        if (isset($universal_pay_save_card)) {
            $_tempBody = $universal_pay_save_card;
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
                '\Swagger\Client\Model\UniversalPayTokenizeByWebResponse',
                '/v2.01/PayInsUniversalPay/token/web'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\Swagger\Client\Model\UniversalPayTokenizeByWebResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\Swagger\Client\Model\UniversalPayTokenizeByWebResponse', $e->getResponseHeaders());
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
