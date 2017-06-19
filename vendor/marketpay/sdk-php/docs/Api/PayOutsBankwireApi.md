# Swagger\Client\PayOutsBankwireApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**payOutsBankwireGet**](PayOutsBankwireApi.md#payOutsBankwireGet) | **GET** /v2.01/PayOutsBankwire/bankwire/{PayOutId} | 
[**payOutsBankwireGet_0**](PayOutsBankwireApi.md#payOutsBankwireGet_0) | **GET** /v2.01/PayOutsBankwire/payments/{PayOutId} | 
[**payOutsBankwirePost**](PayOutsBankwireApi.md#payOutsBankwirePost) | **POST** /v2.01/PayOutsBankwire/bankwire | 
[**payOutsBankwirePost_0**](PayOutsBankwireApi.md#payOutsBankwirePost_0) | **POST** /v2.01/PayOutsBankwire/payments/direct | 


# **payOutsBankwireGet**
> \Swagger\Client\Model\PayOutBankwireResponse payOutsBankwireGet($pay_out_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayOutsBankwireApi();
$pay_out_id = 789; // int | 

try {
    $result = $api_instance->payOutsBankwireGet($pay_out_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayOutsBankwireApi->payOutsBankwireGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_out_id** | **int**|  |

### Return type

[**\Swagger\Client\Model\PayOutBankwireResponse**](../Model/PayOutBankwireResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payOutsBankwireGet_0**
> \Swagger\Client\Model\PayOutBankwireResponse payOutsBankwireGet_0($pay_out_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayOutsBankwireApi();
$pay_out_id = 789; // int | 

try {
    $result = $api_instance->payOutsBankwireGet_0($pay_out_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayOutsBankwireApi->payOutsBankwireGet_0: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_out_id** | **int**|  |

### Return type

[**\Swagger\Client\Model\PayOutBankwireResponse**](../Model/PayOutBankwireResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payOutsBankwirePost**
> \Swagger\Client\Model\PayOutBankwireResponse payOutsBankwirePost($bankwire_pay_out)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayOutsBankwireApi();
$bankwire_pay_out = new \Swagger\Client\Model\PayOutBankwirePost(); // \Swagger\Client\Model\PayOutBankwirePost | 

try {
    $result = $api_instance->payOutsBankwirePost($bankwire_pay_out);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayOutsBankwireApi->payOutsBankwirePost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **bankwire_pay_out** | [**\Swagger\Client\Model\PayOutBankwirePost**](../Model/\Swagger\Client\Model\PayOutBankwirePost.md)|  | [optional]

### Return type

[**\Swagger\Client\Model\PayOutBankwireResponse**](../Model/PayOutBankwireResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payOutsBankwirePost_0**
> \Swagger\Client\Model\PayOutBankwireResponse payOutsBankwirePost_0($bankwire_pay_out)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayOutsBankwireApi();
$bankwire_pay_out = new \Swagger\Client\Model\PayOutBankwirePost(); // \Swagger\Client\Model\PayOutBankwirePost | 

try {
    $result = $api_instance->payOutsBankwirePost_0($bankwire_pay_out);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayOutsBankwireApi->payOutsBankwirePost_0: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **bankwire_pay_out** | [**\Swagger\Client\Model\PayOutBankwirePost**](../Model/\Swagger\Client\Model\PayOutBankwirePost.md)|  | [optional]

### Return type

[**\Swagger\Client\Model\PayOutBankwireResponse**](../Model/PayOutBankwireResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

