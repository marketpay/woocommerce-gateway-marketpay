# Swagger\Client\TransfersApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**transfersGet**](TransfersApi.md#transfersGet) | **GET** /v2.01/Transfers/{TransferId} | View a Transfer
[**transfersGetList**](TransfersApi.md#transfersGetList) | **GET** /v2.01/Transfers | View a Transfer
[**transfersPost**](TransfersApi.md#transfersPost) | **POST** /v2.01/Transfers | Create a Transfer


# **transfersGet**
> \Swagger\Client\Model\TransferResponse transfersGet($transfer_id)

View a Transfer

A Transfer is a request to relocate e-money from one wallet to another wallet.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\TransfersApi();
$transfer_id = 789; // int | The Id of a transfer

try {
    $result = $api_instance->transfersGet($transfer_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransfersApi->transfersGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transfer_id** | **int**| The Id of a transfer |

### Return type

[**\Swagger\Client\Model\TransferResponse**](../Model/TransferResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **transfersGetList**
> \Swagger\Client\Model\ResponseListTransferResponse transfersGetList($page, $per_page, $before_date, $after_date)

View a Transfer

A Transfer is a request to relocate e-money from one wallet to another wallet.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\TransfersApi();
$page = 56; // int | 
$per_page = 56; // int | 
$before_date = 789; // int | 
$after_date = 789; // int | 

try {
    $result = $api_instance->transfersGetList($page, $per_page, $before_date, $after_date);
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

### Return type

[**\Swagger\Client\Model\ResponseListTransferResponse**](../Model/ResponseListTransferResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **transfersPost**
> \Swagger\Client\Model\TransferResponse transfersPost($transfer)

Create a Transfer



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\TransfersApi();
$transfer = new \Swagger\Client\Model\TransferPost(); // \Swagger\Client\Model\TransferPost | Transfer Object params

try {
    $result = $api_instance->transfersPost($transfer);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransfersApi->transfersPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transfer** | [**\Swagger\Client\Model\TransferPost**](../Model/TransferPost.md)| Transfer Object params | [optional]

### Return type

[**\Swagger\Client\Model\TransferResponse**](../Model/TransferResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

