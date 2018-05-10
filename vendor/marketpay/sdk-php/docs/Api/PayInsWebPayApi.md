# MarketPay\PayInsWebPayApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**payInsWebPayDeleteWebPayToken**](PayInsWebPayApi.md#payInsWebPayDeleteWebPayToken) | **DELETE** /v2.01/PayInsWebPay/token/{TokenId} | 
[**payInsWebPayGetWebPayTokenization**](PayInsWebPayApi.md#payInsWebPayGetWebPayTokenization) | **GET** /v2.01/PayInsWebPay/token/{TokenId} | 
[**payInsWebPayWebPayGetPayment**](PayInsWebPayApi.md#payInsWebPayWebPayGetPayment) | **GET** /v2.01/PayInsWebPay/payments/{PayInId} | 
[**payInsWebPayWebPayPostPaymentByWeb**](PayInsWebPayApi.md#payInsWebPayWebPayPostPaymentByWeb) | **POST** /v2.01/PayInsWebPay/payments/web | 
[**payInsWebPayWebPayPostRefund**](PayInsWebPayApi.md#payInsWebPayWebPayPostRefund) | **POST** /v2.01/PayInsWebPay/payments/{PayInId}/refunds | 
[**payInsWebPayWebPaySaveCard**](PayInsWebPayApi.md#payInsWebPayWebPaySaveCard) | **POST** /v2.01/PayInsWebPay/token/web | 


# **payInsWebPayDeleteWebPayToken**
> \MarketPay\Model\WebPayTokenDeleteResponse payInsWebPayDeleteWebPayToken($token_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsWebPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$token_id = 789; // int | 

try {
    $result = $apiInstance->payInsWebPayDeleteWebPayToken($token_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsWebPayApi->payInsWebPayDeleteWebPayToken: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **token_id** | **int**|  |

### Return type

[**\MarketPay\Model\WebPayTokenDeleteResponse**](../Model/WebPayTokenDeleteResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsWebPayGetWebPayTokenization**
> \MarketPay\Model\WebPayTokenizationResponse payInsWebPayGetWebPayTokenization($token_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsWebPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$token_id = 789; // int | 

try {
    $result = $apiInstance->payInsWebPayGetWebPayTokenization($token_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsWebPayApi->payInsWebPayGetWebPayTokenization: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **token_id** | **int**|  |

### Return type

[**\MarketPay\Model\WebPayTokenizationResponse**](../Model/WebPayTokenizationResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsWebPayWebPayGetPayment**
> \MarketPay\Model\WebPayPayInsResponse payInsWebPayWebPayGetPayment($pay_in_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsWebPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pay_in_id = 789; // int | 

try {
    $result = $apiInstance->payInsWebPayWebPayGetPayment($pay_in_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsWebPayApi->payInsWebPayWebPayGetPayment: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**|  |

### Return type

[**\MarketPay\Model\WebPayPayInsResponse**](../Model/WebPayPayInsResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsWebPayWebPayPostPaymentByWeb**
> \MarketPay\Model\WebPayPayByWebResponse payInsWebPayWebPayPostPaymentByWeb($web_pay_pay_in)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsWebPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$web_pay_pay_in = new \MarketPay\Model\WebPayPayByWebPost(); // \MarketPay\Model\WebPayPayByWebPost | 

try {
    $result = $apiInstance->payInsWebPayWebPayPostPaymentByWeb($web_pay_pay_in);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsWebPayApi->payInsWebPayWebPayPostPaymentByWeb: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **web_pay_pay_in** | [**\MarketPay\Model\WebPayPayByWebPost**](../Model/WebPayPayByWebPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\WebPayPayByWebResponse**](../Model/WebPayPayByWebResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsWebPayWebPayPostRefund**
> \MarketPay\Model\WebPayRefundResponse payInsWebPayWebPayPostRefund($pay_in_id, $web_pay_refund)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsWebPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pay_in_id = 789; // int | 
$web_pay_refund = new \MarketPay\Model\WebPayRefundPost(); // \MarketPay\Model\WebPayRefundPost | 

try {
    $result = $apiInstance->payInsWebPayWebPayPostRefund($pay_in_id, $web_pay_refund);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsWebPayApi->payInsWebPayWebPayPostRefund: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**|  |
 **web_pay_refund** | [**\MarketPay\Model\WebPayRefundPost**](../Model/WebPayRefundPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\WebPayRefundResponse**](../Model/WebPayRefundResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsWebPayWebPaySaveCard**
> \MarketPay\Model\WebPayTokenizeByWebResponse payInsWebPayWebPaySaveCard($web_pay_save_card)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsWebPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$web_pay_save_card = new \MarketPay\Model\WebPayTokenRequestPost(); // \MarketPay\Model\WebPayTokenRequestPost | 

try {
    $result = $apiInstance->payInsWebPayWebPaySaveCard($web_pay_save_card);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsWebPayApi->payInsWebPayWebPaySaveCard: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **web_pay_save_card** | [**\MarketPay\Model\WebPayTokenRequestPost**](../Model/WebPayTokenRequestPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\WebPayTokenizeByWebResponse**](../Model/WebPayTokenizeByWebResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

