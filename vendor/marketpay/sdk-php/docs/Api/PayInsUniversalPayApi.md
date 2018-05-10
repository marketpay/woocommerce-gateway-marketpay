# MarketPay\PayInsUniversalPayApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**payInsUniversalPayGetUniversalPayTokenization**](PayInsUniversalPayApi.md#payInsUniversalPayGetUniversalPayTokenization) | **GET** /v2.01/PayInsUniversalPay/token/{TokenId} | 
[**payInsUniversalPayUniversalPayGetPayment**](PayInsUniversalPayApi.md#payInsUniversalPayUniversalPayGetPayment) | **GET** /v2.01/PayInsUniversalPay/payments/{PayInId} | 
[**payInsUniversalPayUniversalPayPostPaymentByWeb**](PayInsUniversalPayApi.md#payInsUniversalPayUniversalPayPostPaymentByWeb) | **POST** /v2.01/PayInsUniversalPay/payments/web | 
[**payInsUniversalPayUniversalPayPostRefund**](PayInsUniversalPayApi.md#payInsUniversalPayUniversalPayPostRefund) | **POST** /v2.01/PayInsUniversalPay/payments/{PayInId}/refunds | 
[**payInsUniversalPayUniversalPaySaveCard**](PayInsUniversalPayApi.md#payInsUniversalPayUniversalPaySaveCard) | **POST** /v2.01/PayInsUniversalPay/token/web | 


# **payInsUniversalPayGetUniversalPayTokenization**
> \MarketPay\Model\UniversalPayTokenizationResponse payInsUniversalPayGetUniversalPayTokenization($token_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsUniversalPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$token_id = 789; // int | 

try {
    $result = $apiInstance->payInsUniversalPayGetUniversalPayTokenization($token_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayGetUniversalPayTokenization: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **token_id** | **int**|  |

### Return type

[**\MarketPay\Model\UniversalPayTokenizationResponse**](../Model/UniversalPayTokenizationResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsUniversalPayUniversalPayGetPayment**
> \MarketPay\Model\UniversalPayPayInsResponse payInsUniversalPayUniversalPayGetPayment($pay_in_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsUniversalPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pay_in_id = 789; // int | 

try {
    $result = $apiInstance->payInsUniversalPayUniversalPayGetPayment($pay_in_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayUniversalPayGetPayment: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**|  |

### Return type

[**\MarketPay\Model\UniversalPayPayInsResponse**](../Model/UniversalPayPayInsResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsUniversalPayUniversalPayPostPaymentByWeb**
> \MarketPay\Model\UniversalPayPayByWebResponse payInsUniversalPayUniversalPayPostPaymentByWeb($universal_pay_pay_in)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsUniversalPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$universal_pay_pay_in = new \MarketPay\Model\UniversalPayPayByWebPost(); // \MarketPay\Model\UniversalPayPayByWebPost | 

try {
    $result = $apiInstance->payInsUniversalPayUniversalPayPostPaymentByWeb($universal_pay_pay_in);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayUniversalPayPostPaymentByWeb: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **universal_pay_pay_in** | [**\MarketPay\Model\UniversalPayPayByWebPost**](../Model/UniversalPayPayByWebPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\UniversalPayPayByWebResponse**](../Model/UniversalPayPayByWebResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsUniversalPayUniversalPayPostRefund**
> \MarketPay\Model\UniversalPayRefundResponse payInsUniversalPayUniversalPayPostRefund($pay_in_id, $universal_pay_refund)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsUniversalPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pay_in_id = 789; // int | 
$universal_pay_refund = new \MarketPay\Model\UniversalPayRefundPost(); // \MarketPay\Model\UniversalPayRefundPost | 

try {
    $result = $apiInstance->payInsUniversalPayUniversalPayPostRefund($pay_in_id, $universal_pay_refund);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayUniversalPayPostRefund: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**|  |
 **universal_pay_refund** | [**\MarketPay\Model\UniversalPayRefundPost**](../Model/UniversalPayRefundPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\UniversalPayRefundResponse**](../Model/UniversalPayRefundResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsUniversalPayUniversalPaySaveCard**
> \MarketPay\Model\UniversalPayTokenizeByWebResponse payInsUniversalPayUniversalPaySaveCard($universal_pay_save_card)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsUniversalPayApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$universal_pay_save_card = new \MarketPay\Model\UniversalPayTokenRequestPost(); // \MarketPay\Model\UniversalPayTokenRequestPost | 

try {
    $result = $apiInstance->payInsUniversalPayUniversalPaySaveCard($universal_pay_save_card);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayUniversalPaySaveCard: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **universal_pay_save_card** | [**\MarketPay\Model\UniversalPayTokenRequestPost**](../Model/UniversalPayTokenRequestPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\UniversalPayTokenizeByWebResponse**](../Model/UniversalPayTokenizeByWebResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

