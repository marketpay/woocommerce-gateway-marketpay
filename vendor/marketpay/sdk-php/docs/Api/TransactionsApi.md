# Swagger\Client\TransactionsApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**transactionsGetList**](TransactionsApi.md#transactionsGetList) | **GET** /v2.01/Transactions | View a Transaction


# **transactionsGetList**
> \Swagger\Client\Model\ResponseListTransactionResponse transactionsGetList($page, $per_page, $before_date, $after_date, $sort)

View a Transaction

A Transaction is any movement of money

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\TransactionsApi();
$page = 56; // int | 
$per_page = 56; // int | 
$before_date = 789; // int | 
$after_date = 789; // int | 
$sort = "sort_example"; // string | 

try {
    $result = $api_instance->transactionsGetList($page, $per_page, $before_date, $after_date, $sort);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsApi->transactionsGetList: ', $e->getMessage(), PHP_EOL;
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

[**\Swagger\Client\Model\ResponseListTransactionResponse**](../Model/ResponseListTransactionResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

