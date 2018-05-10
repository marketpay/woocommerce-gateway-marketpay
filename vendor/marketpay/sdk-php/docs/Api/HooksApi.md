# MarketPay\HooksApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**hooksGet**](HooksApi.md#hooksGet) | **GET** /v2.01/Hooks | 
[**hooksGet_0**](HooksApi.md#hooksGet_0) | **GET** /v2.01/Hooks/{hookId} | 
[**hooksPost**](HooksApi.md#hooksPost) | **POST** /v2.01/Hooks | 
[**hooksPut**](HooksApi.md#hooksPut) | **PUT** /v2.01/Hooks/{hookId} | 


# **hooksGet**
> \MarketPay\Model\HookResponse[] hooksGet($page, $per_page)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\HooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$page = 56; // int | 
$per_page = 56; // int | 

try {
    $result = $apiInstance->hooksGet($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HooksApi->hooksGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**|  | [optional]
 **per_page** | **int**|  | [optional]

### Return type

[**\MarketPay\Model\HookResponse[]**](../Model/HookResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **hooksGet_0**
> \MarketPay\Model\HookResponse hooksGet_0($hook_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\HooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$hook_id = "hook_id_example"; // string | 

try {
    $result = $apiInstance->hooksGet_0($hook_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HooksApi->hooksGet_0: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **hook_id** | **string**|  |

### Return type

[**\MarketPay\Model\HookResponse**](../Model/HookResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **hooksPost**
> \MarketPay\Model\HookResponse hooksPost($request)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\HooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$request = new \MarketPay\Model\HookPost(); // \MarketPay\Model\HookPost | 

try {
    $result = $apiInstance->hooksPost($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HooksApi->hooksPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **request** | [**\MarketPay\Model\HookPost**](../Model/HookPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\HookResponse**](../Model/HookResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **hooksPut**
> \MarketPay\Model\HookResponse hooksPut($hook_id, $request)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\HooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$hook_id = "hook_id_example"; // string | 
$request = new \MarketPay\Model\HookPut(); // \MarketPay\Model\HookPut | 

try {
    $result = $apiInstance->hooksPut($hook_id, $request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HooksApi->hooksPut: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **hook_id** | **string**|  |
 **request** | [**\MarketPay\Model\HookPut**](../Model/HookPut.md)|  | [optional]

### Return type

[**\MarketPay\Model\HookResponse**](../Model/HookResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

