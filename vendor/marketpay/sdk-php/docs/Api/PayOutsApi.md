# Swagger\Client\PayOutsApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**payOutsGet**](PayOutsApi.md#payOutsGet) | **GET** /v2.01/PayOuts/bankwire/{id} | SwaggerDocSummary
[**payOutsPost**](PayOutsApi.md#payOutsPost) | **POST** /v2.01/PayOuts/bankwire | SwaggerDocSummary


# **payOutsGet**
> \Swagger\Client\Model\PayOutBankWireResponse payOutsGet($id)

SwaggerDocSummary

SwaggerDocDescription

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayOutsApi();
$id = 789; // int | SwaggerDocParameter

try {
    $result = $api_instance->payOutsGet($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayOutsApi->payOutsGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**| SwaggerDocParameter |

### Return type

[**\Swagger\Client\Model\PayOutBankWireResponse**](../Model/PayOutBankWireResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payOutsPost**
> \Swagger\Client\Model\PayOutBankWireResponse payOutsPost($request)

SwaggerDocSummary

SwaggerDocDescription

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayOutsApi();
$request = new \Swagger\Client\Model\PayOutBankWirePost(); // \Swagger\Client\Model\PayOutBankWirePost | SwaggerDocParameter

try {
    $result = $api_instance->payOutsPost($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayOutsApi->payOutsPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **request** | [**\Swagger\Client\Model\PayOutBankWirePost**](../Model/\Swagger\Client\Model\PayOutBankWirePost.md)| SwaggerDocParameter | [optional]

### Return type

[**\Swagger\Client\Model\PayOutBankWireResponse**](../Model/PayOutBankWireResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

