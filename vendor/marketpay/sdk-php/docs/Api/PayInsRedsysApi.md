# MarketPay\PayInsRedsysApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**payInsRedsysRedsysGetPayment**](PayInsRedsysApi.md#payInsRedsysRedsysGetPayment) | **GET** /v2.01/PayInsRedsys/payments/{PayInId} | 
[**payInsRedsysRedsysGetPreauthorization**](PayInsRedsysApi.md#payInsRedsysRedsysGetPreauthorization) | **GET** /v2.01/PayInsRedsys/preauthorizations/{PreauthorizationId} | 
[**payInsRedsysRedsysPostPaymentByWeb**](PayInsRedsysApi.md#payInsRedsysRedsysPostPaymentByWeb) | **POST** /v2.01/PayInsRedsys/payments/web | 
[**payInsRedsysRedsysPostPreauthorizationByWeb**](PayInsRedsysApi.md#payInsRedsysRedsysPostPreauthorizationByWeb) | **POST** /v2.01/PayInsRedsys/preauthorizations/web | 
[**payInsRedsysRedsysPostPreauthorizationCancellation**](PayInsRedsysApi.md#payInsRedsysRedsysPostPreauthorizationCancellation) | **POST** /v2.01/PayInsRedsys/preauthorizations/{PreauthorizationId}/cancellation | 
[**payInsRedsysRedsysPostPreauthorizationConfirmation**](PayInsRedsysApi.md#payInsRedsysRedsysPostPreauthorizationConfirmation) | **POST** /v2.01/PayInsRedsys/preauthorizations/{PreauthorizationId}/confirmation | 
[**payInsRedsysRedsysPostRefund**](PayInsRedsysApi.md#payInsRedsysRedsysPostRefund) | **POST** /v2.01/PayInsRedsys/payments/{PayInId}/refunds | 


# **payInsRedsysRedsysGetPayment**
> \MarketPay\Model\RedsysPayInsResponse payInsRedsysRedsysGetPayment($pay_in_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsRedsysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pay_in_id = 789; // int | 

try {
    $result = $apiInstance->payInsRedsysRedsysGetPayment($pay_in_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsRedsysApi->payInsRedsysRedsysGetPayment: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**|  |

### Return type

[**\MarketPay\Model\RedsysPayInsResponse**](../Model/RedsysPayInsResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsRedsysRedsysGetPreauthorization**
> \MarketPay\Model\RedsysPreauthorizeResponse payInsRedsysRedsysGetPreauthorization($preauthorization_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsRedsysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$preauthorization_id = 789; // int | 

try {
    $result = $apiInstance->payInsRedsysRedsysGetPreauthorization($preauthorization_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsRedsysApi->payInsRedsysRedsysGetPreauthorization: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **preauthorization_id** | **int**|  |

### Return type

[**\MarketPay\Model\RedsysPreauthorizeResponse**](../Model/RedsysPreauthorizeResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsRedsysRedsysPostPaymentByWeb**
> \MarketPay\Model\RedsysPayByWebResponse payInsRedsysRedsysPostPaymentByWeb($x_webhook, $redsys_pay_in)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsRedsysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$x_webhook = "x_webhook_example"; // string | 
$redsys_pay_in = new \MarketPay\Model\RedsysPayByWebPost(); // \MarketPay\Model\RedsysPayByWebPost | 

try {
    $result = $apiInstance->payInsRedsysRedsysPostPaymentByWeb($x_webhook, $redsys_pay_in);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsRedsysApi->payInsRedsysRedsysPostPaymentByWeb: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **x_webhook** | **string**|  | [optional]
 **redsys_pay_in** | [**\MarketPay\Model\RedsysPayByWebPost**](../Model/RedsysPayByWebPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\RedsysPayByWebResponse**](../Model/RedsysPayByWebResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsRedsysRedsysPostPreauthorizationByWeb**
> \MarketPay\Model\RedsysPreauthorizeByWebResponse payInsRedsysRedsysPostPreauthorizationByWeb($redsys_preauthorization)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsRedsysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$redsys_preauthorization = new \MarketPay\Model\RedsysPreauthorizeByWebPost(); // \MarketPay\Model\RedsysPreauthorizeByWebPost | 

try {
    $result = $apiInstance->payInsRedsysRedsysPostPreauthorizationByWeb($redsys_preauthorization);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsRedsysApi->payInsRedsysRedsysPostPreauthorizationByWeb: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **redsys_preauthorization** | [**\MarketPay\Model\RedsysPreauthorizeByWebPost**](../Model/RedsysPreauthorizeByWebPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\RedsysPreauthorizeByWebResponse**](../Model/RedsysPreauthorizeByWebResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsRedsysRedsysPostPreauthorizationCancellation**
> \MarketPay\Model\RedsysPreauthorizationCancellationResponse payInsRedsysRedsysPostPreauthorizationCancellation($preauthorization_id, $redsys_preauthorization_cancellation)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsRedsysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$preauthorization_id = 789; // int | 
$redsys_preauthorization_cancellation = new \MarketPay\Model\RedsysPreauthorizationCancellationPost(); // \MarketPay\Model\RedsysPreauthorizationCancellationPost | 

try {
    $result = $apiInstance->payInsRedsysRedsysPostPreauthorizationCancellation($preauthorization_id, $redsys_preauthorization_cancellation);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsRedsysApi->payInsRedsysRedsysPostPreauthorizationCancellation: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **preauthorization_id** | **int**|  |
 **redsys_preauthorization_cancellation** | [**\MarketPay\Model\RedsysPreauthorizationCancellationPost**](../Model/RedsysPreauthorizationCancellationPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\RedsysPreauthorizationCancellationResponse**](../Model/RedsysPreauthorizationCancellationResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsRedsysRedsysPostPreauthorizationConfirmation**
> \MarketPay\Model\RedsysPreauthorizationConfirmationResponse payInsRedsysRedsysPostPreauthorizationConfirmation($preauthorization_id, $redsys_preauthorization_confirmation)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsRedsysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$preauthorization_id = 789; // int | 
$redsys_preauthorization_confirmation = new \MarketPay\Model\RedsysPreauthorizationConfirmationPost(); // \MarketPay\Model\RedsysPreauthorizationConfirmationPost | 

try {
    $result = $apiInstance->payInsRedsysRedsysPostPreauthorizationConfirmation($preauthorization_id, $redsys_preauthorization_confirmation);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsRedsysApi->payInsRedsysRedsysPostPreauthorizationConfirmation: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **preauthorization_id** | **int**|  |
 **redsys_preauthorization_confirmation** | [**\MarketPay\Model\RedsysPreauthorizationConfirmationPost**](../Model/RedsysPreauthorizationConfirmationPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\RedsysPreauthorizationConfirmationResponse**](../Model/RedsysPreauthorizationConfirmationResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsRedsysRedsysPostRefund**
> \MarketPay\Model\RedsysRefundResponse payInsRedsysRedsysPostRefund($pay_in_id, $redsys_refund)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\PayInsRedsysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pay_in_id = 789; // int | 
$redsys_refund = new \MarketPay\Model\RedsysRefundPost(); // \MarketPay\Model\RedsysRefundPost | 

try {
    $result = $apiInstance->payInsRedsysRedsysPostRefund($pay_in_id, $redsys_refund);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsRedsysApi->payInsRedsysRedsysPostRefund: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**|  |
 **redsys_refund** | [**\MarketPay\Model\RedsysRefundPost**](../Model/RedsysRefundPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\RedsysRefundResponse**](../Model/RedsysRefundResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

