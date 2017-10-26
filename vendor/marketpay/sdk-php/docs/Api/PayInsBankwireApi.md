# Swagger\Client\PayInsBankwireApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**payInsBankwireBankwireGetPayment**](PayInsBankwireApi.md#payInsBankwireBankwireGetPayment) | **GET** /v2.01/PayInsBankwire/payments/{PayInId} | View a Bankwire PayIn
[**payInsBankwireBankwirePaymentByDirect**](PayInsBankwireApi.md#payInsBankwireBankwirePaymentByDirect) | **POST** /v2.01/PayInsBankwire/payments/direct | Create a Bankwire PayIn


# **payInsBankwireBankwireGetPayment**
> \Swagger\Client\Model\PayInBankwireResponse payInsBankwireBankwireGetPayment($pay_in_id)

View a Bankwire PayIn

View a Bankwire PayIn

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsBankwireApi();
$pay_in_id = 789; // int | The Id of a payment

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
 **pay_in_id** | **int**| The Id of a payment |

### Return type

[**\Swagger\Client\Model\PayInBankwireResponse**](../Model/PayInBankwireResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsBankwireBankwirePaymentByDirect**
> \Swagger\Client\Model\PayInBankwireResponse payInsBankwireBankwirePaymentByDirect($bankwire_pay_in)

Create a Bankwire PayIn

Create a Bankwire PayIn.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsBankwireApi();
$bankwire_pay_in = new \Swagger\Client\Model\PayInBankwirePost(); // \Swagger\Client\Model\PayInBankwirePost | Redsys PayIn Request Object params

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
 **bankwire_pay_in** | [**\Swagger\Client\Model\PayInBankwirePost**](../Model/PayInBankwirePost.md)| Redsys PayIn Request Object params | [optional]

### Return type

[**\Swagger\Client\Model\PayInBankwireResponse**](../Model/PayInBankwireResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

