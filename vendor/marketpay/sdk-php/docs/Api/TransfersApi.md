# MarketPay\TransfersApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**transfersGet**](TransfersApi.md#transfersGet) | **GET** /v2.01/Transfers/{TransferId} | 
[**transfersGetList**](TransfersApi.md#transfersGetList) | **GET** /v2.01/Transfers | 
[**transfersPost**](TransfersApi.md#transfersPost) | **POST** /v2.01/Transfers | 


# **transfersGet**
> \MarketPay\Model\TransferResponse transfersGet($transfer_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\TransfersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transfer_id = 789; // int | 

try {
    $result = $apiInstance->transfersGet($transfer_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransfersApi->transfersGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transfer_id** | **int**|  |

### Return type

[**\MarketPay\Model\TransferResponse**](../Model/TransferResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **transfersGetList**
> \MarketPay\Model\ResponseListTransferResponse transfersGetList($page, $per_page, $before_date, $after_date, $sort)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\TransfersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$page = 56; // int | 
$per_page = 56; // int | 
$before_date = 789; // int | 
$after_date = 789; // int | 
$sort = "sort_example"; // string | 

try {
    $result = $apiInstance->transfersGetList($page, $per_page, $before_date, $after_date, $sort);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransfersApi->transfersGetList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**|  | [optional]
 **per_page** | **int**|  | [optional]
 **before_date** | **int**|  | [optional]
 **after_date** | **int**|  | [optional]
 **sort** | **string**|  | [optional]

### Return type

[**\MarketPay\Model\ResponseListTransferResponse**](../Model/ResponseListTransferResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **transfersPost**
> \MarketPay\Model\TransferResponse transfersPost($transfer)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\TransfersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transfer = new \MarketPay\Model\TransferPost(); // \MarketPay\Model\TransferPost | 

try {
    $result = $apiInstance->transfersPost($transfer);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransfersApi->transfersPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transfer** | [**\MarketPay\Model\TransferPost**](../Model/TransferPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\TransferResponse**](../Model/TransferResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

