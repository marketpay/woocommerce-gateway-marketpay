# Swagger\Client\PayInsUniversalPayApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**payInsUniversalPayGetUniversalPayTokenization**](PayInsUniversalPayApi.md#payInsUniversalPayGetUniversalPayTokenization) | **GET** /v2.01/PayInsUniversalPay/token/{TokenId} | View a UniversalPay card tokenization status
[**payInsUniversalPayUniversalPayGetPayment**](PayInsUniversalPayApi.md#payInsUniversalPayUniversalPayGetPayment) | **GET** /v2.01/PayInsUniversalPay/payments/{PayInId} | View a UniversalPay payment
[**payInsUniversalPayUniversalPayPostPaymentByWeb**](PayInsUniversalPayApi.md#payInsUniversalPayUniversalPayPostPaymentByWeb) | **POST** /v2.01/PayInsUniversalPay/payments/web | Create a UniversalPay PayIn Request
[**payInsUniversalPayUniversalPayPostRefund**](PayInsUniversalPayApi.md#payInsUniversalPayUniversalPayPostRefund) | **POST** /v2.01/PayInsUniversalPay/payments/{PayInId}/refunds | Create a UniversalPay Payment Refund
[**payInsUniversalPayUniversalPaySaveCard**](PayInsUniversalPayApi.md#payInsUniversalPayUniversalPaySaveCard) | **POST** /v2.01/PayInsUniversalPay/token/web | 


# **payInsUniversalPayGetUniversalPayTokenization**
> \Swagger\Client\Model\UniversalPayTokenizationResponse payInsUniversalPayGetUniversalPayTokenization($token_id)

View a UniversalPay card tokenization status



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsUniversalPayApi();
$token_id = 789; // int | The Id of a tokenization

try {
    $result = $api_instance->payInsUniversalPayGetUniversalPayTokenization($token_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayGetUniversalPayTokenization: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **token_id** | **int**| The Id of a tokenization |

### Return type

[**\Swagger\Client\Model\UniversalPayTokenizationResponse**](../Model/UniversalPayTokenizationResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsUniversalPayUniversalPayGetPayment**
> \Swagger\Client\Model\UniversalPayPayInsResponse payInsUniversalPayUniversalPayGetPayment($pay_in_id)

View a UniversalPay payment



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsUniversalPayApi();
$pay_in_id = 789; // int | The Id of a payment

try {
    $result = $api_instance->payInsUniversalPayUniversalPayGetPayment($pay_in_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayUniversalPayGetPayment: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**| The Id of a payment |

### Return type

[**\Swagger\Client\Model\UniversalPayPayInsResponse**](../Model/UniversalPayPayInsResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsUniversalPayUniversalPayPostPaymentByWeb**
> \Swagger\Client\Model\UniversalPayPayByWebResponse payInsUniversalPayUniversalPayPostPaymentByWeb($universal_pay_pay_in)

Create a UniversalPay PayIn Request

Prepares a payment on UniversalPay. The data returned is used to show the UniversalPay interface to the user.  Once the payment is done, the user will be redirected to one of UrlOk or UrlKo passed parameters.  In order to redirect the user, a Post request with Content-Type of application/x-www-form-urlencoded must be executed from the user's browser.  Below there is an example of a request where the params surrounded by curly braces have to be replaced with the response's params.  curl -X POST -H \"Content-Type: application/x-www-form-urlencoded\" -H \"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*_/_*;q=0.8\" -H \"Cache-Control: no-cache\" -d 'Ds_SignatureVersion={Ds_SignatureVersion}&amp;Ds_MerchantParameters={Ds_MerchantParameters}&amp;Ds_Signature={Ds_Signature}' \"{Url}\"

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsUniversalPayApi();
$universal_pay_pay_in = new \Swagger\Client\Model\UniversalPayPayByWebPost(); // \Swagger\Client\Model\UniversalPayPayByWebPost | UniversalPay PayIn Request Object params

try {
    $result = $api_instance->payInsUniversalPayUniversalPayPostPaymentByWeb($universal_pay_pay_in);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayUniversalPayPostPaymentByWeb: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **universal_pay_pay_in** | [**\Swagger\Client\Model\UniversalPayPayByWebPost**](../Model/UniversalPayPayByWebPost.md)| UniversalPay PayIn Request Object params | [optional]

### Return type

[**\Swagger\Client\Model\UniversalPayPayByWebResponse**](../Model/UniversalPayPayByWebResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsUniversalPayUniversalPayPostRefund**
> \Swagger\Client\Model\UniversalPayRefundResponse payInsUniversalPayUniversalPayPostRefund($pay_in_id, $universal_pay_refund)

Create a UniversalPay Payment Refund

A PayIn Refund is a request to reimburse a user on their payment card. The money which has already been paid will automatically go back to the user’s bank account.              Minimum amount to refund is 1€.              If you're doing a partial Refund, note that you can only refund the same amount on the same transaction once per day (this is to prevent unintended duplicate refunds). After 24h you can do another refund of the same amount on the same transaction. If it is a different amount on the same transaction, there is not this limit.              If you do not specify DebitedFunds and Fees parameters, it will automatically fully refund the PayIn. However if you do provide one or the other, you must provide both. Note that Fees must be negative if you wish to refund them - adding a positive value for the Fees is a way to charge your customers for the Refund (in the same way you might for a PayIn, Transfer or any other Transaction

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsUniversalPayApi();
$pay_in_id = 789; // int | The Id of a PayIn
$universal_pay_refund = new \Swagger\Client\Model\UniversalPayRefundPost(); // \Swagger\Client\Model\UniversalPayRefundPost | Refund Object params

try {
    $result = $api_instance->payInsUniversalPayUniversalPayPostRefund($pay_in_id, $universal_pay_refund);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayUniversalPayPostRefund: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **pay_in_id** | **int**| The Id of a PayIn |
 **universal_pay_refund** | [**\Swagger\Client\Model\UniversalPayRefundPost**](../Model/UniversalPayRefundPost.md)| Refund Object params | [optional]

### Return type

[**\Swagger\Client\Model\UniversalPayRefundResponse**](../Model/UniversalPayRefundResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **payInsUniversalPayUniversalPaySaveCard**
> \Swagger\Client\Model\UniversalPayTokenizeByWebResponse payInsUniversalPayUniversalPaySaveCard($universal_pay_save_card)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\PayInsUniversalPayApi();
$universal_pay_save_card = new \Swagger\Client\Model\UniversalPayTokenRequestPost(); // \Swagger\Client\Model\UniversalPayTokenRequestPost | 

try {
    $result = $api_instance->payInsUniversalPayUniversalPaySaveCard($universal_pay_save_card);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PayInsUniversalPayApi->payInsUniversalPayUniversalPaySaveCard: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **universal_pay_save_card** | [**\Swagger\Client\Model\UniversalPayTokenRequestPost**](../Model/UniversalPayTokenRequestPost.md)|  | [optional]

### Return type

[**\Swagger\Client\Model\UniversalPayTokenizeByWebResponse**](../Model/UniversalPayTokenizeByWebResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

