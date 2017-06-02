# Swagger\Client\WalletsApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**walletsGet**](WalletsApi.md#walletsGet) | **GET** /v2.01/Wallets/{WalletId} | View a Wallet
[**walletsGetList**](WalletsApi.md#walletsGetList) | **GET** /v2.01/Wallets | 
[**walletsGetTransactionList**](WalletsApi.md#walletsGetTransactionList) | **GET** /v2.01/Wallets/{WalletId}/transactions | List a Wallet&#39;s Transactions
[**walletsPost**](WalletsApi.md#walletsPost) | **POST** /v2.01/Wallets | Create a Wallet
[**walletsPut**](WalletsApi.md#walletsPut) | **PUT** /v2.01/Wallets/{WalletId} | Update a Wallet


# **walletsGet**
> \Swagger\Client\Model\WalletResponse walletsGet($wallet_id)

View a Wallet

A Wallet is an object in which PayIns and Transfers from users are stored in order to collect money. You can pay into a Wallet, withdraw funds from a wallet or transfer funds from a Wallet to another Wallet.              Once a wallet is created, its Currency can not be changed

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\WalletsApi();
$wallet_id = 789; // int | The Id of a wallet

try {
    $result = $api_instance->walletsGet($wallet_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WalletsApi->walletsGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wallet_id** | **int**| The Id of a wallet |

### Return type

[**\Swagger\Client\Model\WalletResponse**](../Model/WalletResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **walletsGetList**
> \Swagger\Client\Model\ResponseListWalletResponse walletsGetList($page, $per_page)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\WalletsApi();
$page = 56; // int | 
$per_page = 56; // int | 

try {
    $result = $api_instance->walletsGetList($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WalletsApi->walletsGetList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**|  | [optional]
 **per_page** | **int**|  | [optional]

### Return type

[**\Swagger\Client\Model\ResponseListWalletResponse**](../Model/ResponseListWalletResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **walletsGetTransactionList**
> \Swagger\Client\Model\TransactionResponse[] walletsGetTransactionList($wallet_id, $page, $per_page)

List a Wallet's Transactions



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\WalletsApi();
$wallet_id = 789; // int | The Id of a wallet
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $api_instance->walletsGetTransactionList($wallet_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WalletsApi->walletsGetTransactionList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wallet_id** | **int**| The Id of a wallet |
 **page** | **int**| The page number of results you wish to return | [optional]
 **per_page** | **int**| The number of results to return per page | [optional]

### Return type

[**\Swagger\Client\Model\TransactionResponse[]**](../Model/TransactionResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **walletsPost**
> \Swagger\Client\Model\WalletResponse walletsPost($wallet)

Create a Wallet



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\WalletsApi();
$wallet = new \Swagger\Client\Model\WalletPost(); // \Swagger\Client\Model\WalletPost | Wallet Object params

try {
    $result = $api_instance->walletsPost($wallet);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WalletsApi->walletsPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wallet** | [**\Swagger\Client\Model\WalletPost**](../Model/\Swagger\Client\Model\WalletPost.md)| Wallet Object params | [optional]

### Return type

[**\Swagger\Client\Model\WalletResponse**](../Model/WalletResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **walletsPut**
> \Swagger\Client\Model\WalletResponse walletsPut($wallet_id, $wallet)

Update a Wallet



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\WalletsApi();
$wallet_id = 789; // int | The Id of a wallet
$wallet = new \Swagger\Client\Model\WalletPut(); // \Swagger\Client\Model\WalletPut | Wallet Object params

try {
    $result = $api_instance->walletsPut($wallet_id, $wallet);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WalletsApi->walletsPut: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wallet_id** | **int**| The Id of a wallet |
 **wallet** | [**\Swagger\Client\Model\WalletPut**](../Model/\Swagger\Client\Model\WalletPut.md)| Wallet Object params | [optional]

### Return type

[**\Swagger\Client\Model\WalletResponse**](../Model/WalletResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

