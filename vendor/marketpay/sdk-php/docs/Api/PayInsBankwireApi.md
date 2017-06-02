# Swagger\Client\PayInsBankwireApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**payInsBankwireBankwireGetPayment**](PayInsBankwireApi.md#payInsBankwireBankwireGetPayment) | **GET** /v2.01/PayInsBankwire/payments/{PayInId} | 
[**payInsBankwireBankwirePaymentByDirect**](PayInsBankwireApi.md#payInsBankwireBankwirePaymentByDirect) | **POST** /v2.01/PayInsBankwire/payments/direct | 


# **payInsBankwireBankwireGetPayment**
> \Swagger\Client\Model\BankwirePayInPayInResponse payInsBankwireBankwireGetPayment($pay_in_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsBankwireApi();
$pay_in_id = 789; // int | 

try {
    $result = $api_instance->payInsBankwireBankwireGetPayment($pay_in_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsBankwireApi->payInsBankwireBankwireGetPayment: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**|  |

### Return type

[**\Swagger\Client\Model\BankwirePayInPayInResponse**](../Model/BankwirePayInPayInResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsBankwireBankwirePaymentByDirect**
> \Swagger\Client\Model\BankwirePayInPayInResponse payInsBankwireBankwirePaymentByDirect($bankwire_pay_in)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsBankwireApi();
$bankwire_pay_in = new \Swagger\Client\Model\BankwirePayInPayInPost(); // \Swagger\Client\Model\BankwirePayInPayInPost | 

try {
    $result = $api_instance->payInsBankwireBankwirePaymentByDirect($bankwire_pay_in);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsBankwireApi->payInsBankwireBankwirePaymentByDirect: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **bankwire_pay_in** | [**\Swagger\Client\Model\BankwirePayInPayInPost**](../Model/\Swagger\Client\Model\BankwirePayInPayInPost.md)|  | [optional]

### Return type

[**\Swagger\Client\Model\BankwirePayInPayInResponse**](../Model/BankwirePayInPayInResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

