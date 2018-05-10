# MarketPay\UsersApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**usersGet**](UsersApi.md#usersGet) | **GET** /v2.01/Users/{UserId} | View a User
[**usersGetBankAccount**](UsersApi.md#usersGetBankAccount) | **GET** /v2.01/Users/{UserId}/bankaccounts/{BankAccountId} | View a Bank Account
[**usersGetBankAccountList**](UsersApi.md#usersGetBankAccountList) | **GET** /v2.01/Users/{UserId}/bankaccounts | List Bank Accounts for a User
[**usersGetCardList**](UsersApi.md#usersGetCardList) | **GET** /v2.01/Users/{UserId}/cards | List Cards for a User
[**usersGetLegal**](UsersApi.md#usersGetLegal) | **GET** /v2.01/Users/legal/{UserId} | View a Legal User
[**usersGetList**](UsersApi.md#usersGetList) | **GET** /v2.01/Users | List all Users
[**usersGetListNatural**](UsersApi.md#usersGetListNatural) | **GET** /v2.01/Users/natural | List all Natural Users
[**usersGetNatural**](UsersApi.md#usersGetNatural) | **GET** /v2.01/Users/natural/{UserId} | View a Natural User
[**usersGetTransactionList**](UsersApi.md#usersGetTransactionList) | **GET** /v2.01/Users/{UserId}/transactions | List Transactions for a User
[**usersGetWalletList**](UsersApi.md#usersGetWalletList) | **GET** /v2.01/Users/{UserId}/wallets | List Wallets for a User
[**usersPostBankAccountCa**](UsersApi.md#usersPostBankAccountCa) | **POST** /v2.01/Users/{UserId}/bankaccounts/CA | Create a CA BankAccount
[**usersPostBankAccountGb**](UsersApi.md#usersPostBankAccountGb) | **POST** /v2.01/Users/{UserId}/bankaccounts/GB | Create a GB BankAccount
[**usersPostBankAccountIban**](UsersApi.md#usersPostBankAccountIban) | **POST** /v2.01/Users/{UserId}/bankaccounts/IBAN | Create an IBAN BankAccount
[**usersPostBankAccountOther**](UsersApi.md#usersPostBankAccountOther) | **POST** /v2.01/Users/{UserId}/bankaccounts/OTHER | Create an OTHER BankAccount
[**usersPostBankAccountUs**](UsersApi.md#usersPostBankAccountUs) | **POST** /v2.01/Users/{UserId}/bankaccounts/US | Create an US BankAccount
[**usersPostLegal**](UsersApi.md#usersPostLegal) | **POST** /v2.01/Users/legal | Create a Legal User
[**usersPostNatural**](UsersApi.md#usersPostNatural) | **POST** /v2.01/Users/natural | Create a Natural User
[**usersPutLegal**](UsersApi.md#usersPutLegal) | **PUT** /v2.01/Users/legal/{UserId} | Update a Legal User
[**usersPutNatural**](UsersApi.md#usersPutNatural) | **PUT** /v2.01/Users/natural/{UserId} | Update a Natural User


# **usersGet**
> \MarketPay\Model\UserResponse usersGet($user_id)

View a User

A User can be \"Natural\" or \"Legal\". With a UserId, you are able to:              Fetch a user and get their details              List all the wallets of a user              Get all your users in a list

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user

try {
    $result = $apiInstance->usersGet($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |

### Return type

[**\MarketPay\Model\UserResponse**](../Model/UserResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetBankAccount**
> \MarketPay\Model\BankAccountResponse usersGetBankAccount($user_id, $bank_account_id)

View a Bank Account



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | The Id of a user
$bank_account_id = 56; // int | The Id of a bank account

try {
    $result = $apiInstance->usersGetBankAccount($user_id, $bank_account_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetBankAccount: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **bank_account_id** | **int**| The Id of a bank account |

### Return type

[**\MarketPay\Model\BankAccountResponse**](../Model/BankAccountResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetBankAccountList**
> \MarketPay\Model\BankAccountResponse[] usersGetBankAccountList($user_id, $page, $per_page)

List Bank Accounts for a User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $apiInstance->usersGetBankAccountList($user_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetBankAccountList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **page** | **int**| The page number of results you wish to return | [optional]
 **per_page** | **int**| The number of results to return per page | [optional]

### Return type

[**\MarketPay\Model\BankAccountResponse[]**](../Model/BankAccountResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetCardList**
> \MarketPay\Model\CardResponse[] usersGetCardList($user_id, $page, $per_page)

List Cards for a User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $apiInstance->usersGetCardList($user_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetCardList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **page** | **int**| The page number of results you wish to return | [optional]
 **per_page** | **int**| The number of results to return per page | [optional]

### Return type

[**\MarketPay\Model\CardResponse[]**](../Model/CardResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetLegal**
> \MarketPay\Model\UserLegalResponse usersGetLegal($user_id)

View a Legal User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a legal user

try {
    $result = $apiInstance->usersGetLegal($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetLegal: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a legal user |

### Return type

[**\MarketPay\Model\UserLegalResponse**](../Model/UserLegalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetList**
> \MarketPay\Model\UserResponse[] usersGetList($page, $per_page)

List all Users



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $apiInstance->usersGetList($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| The page number of results you wish to return | [optional]
 **per_page** | **int**| The number of results to return per page | [optional]

### Return type

[**\MarketPay\Model\UserResponse[]**](../Model/UserResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetListNatural**
> \MarketPay\Model\ResponseListUserResponse usersGetListNatural($page, $per_page, $first_name_contains, $last_name_contains)

List all Natural Users



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page
$first_name_contains = "first_name_contains_example"; // string | 
$last_name_contains = "last_name_contains_example"; // string | 

try {
    $result = $apiInstance->usersGetListNatural($page, $per_page, $first_name_contains, $last_name_contains);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetListNatural: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| The page number of results you wish to return | [optional]
 **per_page** | **int**| The number of results to return per page | [optional]
 **first_name_contains** | **string**|  | [optional]
 **last_name_contains** | **string**|  | [optional]

### Return type

[**\MarketPay\Model\ResponseListUserResponse**](../Model/ResponseListUserResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetNatural**
> \MarketPay\Model\UserNaturalResponse usersGetNatural($user_id)

View a Natural User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a natural user

try {
    $result = $apiInstance->usersGetNatural($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetNatural: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a natural user |

### Return type

[**\MarketPay\Model\UserNaturalResponse**](../Model/UserNaturalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetTransactionList**
> \MarketPay\Model\TransactionResponse[] usersGetTransactionList($user_id, $page, $per_page)

List Transactions for a User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $apiInstance->usersGetTransactionList($user_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetTransactionList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **page** | **int**| The page number of results you wish to return | [optional]
 **per_page** | **int**| The number of results to return per page | [optional]

### Return type

[**\MarketPay\Model\TransactionResponse[]**](../Model/TransactionResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetWalletList**
> \MarketPay\Model\WalletResponse[] usersGetWalletList($user_id, $page, $per_page)

List Wallets for a User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $apiInstance->usersGetWalletList($user_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersGetWalletList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **page** | **int**| The page number of results you wish to return | [optional]
 **per_page** | **int**| The number of results to return per page | [optional]

### Return type

[**\MarketPay\Model\WalletResponse[]**](../Model/WalletResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountCa**
> \MarketPay\Model\BankAccountCaResponse usersPostBankAccountCa($user_id, $bank_account_ca)

Create a CA BankAccount

In the case of CAD PayOut, the author (AuthorId) of the PayOut should have their address (Address for Natural Users or HeaquartersAddress for Legal Users) completed in their User object

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$bank_account_ca = new \MarketPay\Model\BankAccountCaPost(); // \MarketPay\Model\BankAccountCaPost | BankAccountCA Object params

try {
    $result = $apiInstance->usersPostBankAccountCa($user_id, $bank_account_ca);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostBankAccountCa: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **bank_account_ca** | [**\MarketPay\Model\BankAccountCaPost**](../Model/BankAccountCaPost.md)| BankAccountCA Object params | [optional]

### Return type

[**\MarketPay\Model\BankAccountCaResponse**](../Model/BankAccountCaResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountGb**
> \MarketPay\Model\BankAccountGbResponse usersPostBankAccountGb($user_id, $bank_account_gb)

Create a GB BankAccount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$bank_account_gb = new \MarketPay\Model\BankAccountGbPost(); // \MarketPay\Model\BankAccountGbPost | 

try {
    $result = $apiInstance->usersPostBankAccountGb($user_id, $bank_account_gb);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostBankAccountGb: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **bank_account_gb** | [**\MarketPay\Model\BankAccountGbPost**](../Model/BankAccountGbPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\BankAccountGbResponse**](../Model/BankAccountGbResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountIban**
> \MarketPay\Model\BankAccountIbanResponse usersPostBankAccountIban($user_id, $bank_account_iban)

Create an IBAN BankAccount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$bank_account_iban = new \MarketPay\Model\BankAccountIbanPost(); // \MarketPay\Model\BankAccountIbanPost | BankAccountIBAN Object params

try {
    $result = $apiInstance->usersPostBankAccountIban($user_id, $bank_account_iban);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostBankAccountIban: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **bank_account_iban** | [**\MarketPay\Model\BankAccountIbanPost**](../Model/BankAccountIbanPost.md)| BankAccountIBAN Object params | [optional]

### Return type

[**\MarketPay\Model\BankAccountIbanResponse**](../Model/BankAccountIbanResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountOther**
> \MarketPay\Model\BankAccountOtherResponse usersPostBankAccountOther($user_id, $bank_account_other)

Create an OTHER BankAccount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$bank_account_other = new \MarketPay\Model\BankAccountOtherPost(); // \MarketPay\Model\BankAccountOtherPost | 

try {
    $result = $apiInstance->usersPostBankAccountOther($user_id, $bank_account_other);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostBankAccountOther: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **bank_account_other** | [**\MarketPay\Model\BankAccountOtherPost**](../Model/BankAccountOtherPost.md)|  | [optional]

### Return type

[**\MarketPay\Model\BankAccountOtherResponse**](../Model/BankAccountOtherResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountUs**
> \MarketPay\Model\BankAccountUsResponse usersPostBankAccountUs($user_id, $bank_account_us)

Create an US BankAccount

In the case of USD PayOut, the author (AuthorId) of the PayOut should have their address (Address for Natural Users or HeaquartersAddress for Legal Users) completed in their User object.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$bank_account_us = new \MarketPay\Model\BankAccountUsPost(); // \MarketPay\Model\BankAccountUsPost | BankAccountUS Object params

try {
    $result = $apiInstance->usersPostBankAccountUs($user_id, $bank_account_us);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostBankAccountUs: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **bank_account_us** | [**\MarketPay\Model\BankAccountUsPost**](../Model/BankAccountUsPost.md)| BankAccountUS Object params | [optional]

### Return type

[**\MarketPay\Model\BankAccountUsResponse**](../Model/BankAccountUsResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostLegal**
> \MarketPay\Model\UserLegalResponse usersPostLegal($user_legal)

Create a Legal User

Note that the LegalRepresentativeBirthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_legal = new \MarketPay\Model\UserLegalPost(); // \MarketPay\Model\UserLegalPost | UserLegal Object params

try {
    $result = $apiInstance->usersPostLegal($user_legal);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostLegal: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_legal** | [**\MarketPay\Model\UserLegalPost**](../Model/UserLegalPost.md)| UserLegal Object params | [optional]

### Return type

[**\MarketPay\Model\UserLegalResponse**](../Model/UserLegalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostNatural**
> \MarketPay\Model\UserNaturalResponse usersPostNatural($user_natural)

Create a Natural User

Note that the Birthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_natural = new \MarketPay\Model\UserNaturalPost(); // \MarketPay\Model\UserNaturalPost | UserNatural Object params

try {
    $result = $apiInstance->usersPostNatural($user_natural);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostNatural: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_natural** | [**\MarketPay\Model\UserNaturalPost**](../Model/UserNaturalPost.md)| UserNatural Object params | [optional]

### Return type

[**\MarketPay\Model\UserNaturalResponse**](../Model/UserNaturalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPutLegal**
> \MarketPay\Model\UserLegalResponse usersPutLegal($user_id, $user_legal)

Update a Legal User

Note that the LegalRepresentativeBirthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$user_legal = new \MarketPay\Model\UserLegalPut(); // \MarketPay\Model\UserLegalPut | UserLegal Object params

try {
    $result = $apiInstance->usersPutLegal($user_id, $user_legal);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPutLegal: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **user_legal** | [**\MarketPay\Model\UserLegalPut**](../Model/UserLegalPut.md)| UserLegal Object params | [optional]

### Return type

[**\MarketPay\Model\UserLegalResponse**](../Model/UserLegalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPutNatural**
> \MarketPay\Model\UserNaturalResponse usersPutNatural($user_id, $user_natural)

Update a Natural User

Note that the Birthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
$config = MarketPay\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new MarketPay\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 789; // int | The Id of a user
$user_natural = new \MarketPay\Model\UserNaturalPut(); // \MarketPay\Model\UserNaturalPut | UserNatural Object params

try {
    $result = $apiInstance->usersPutNatural($user_id, $user_natural);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPutNatural: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **user_natural** | [**\MarketPay\Model\UserNaturalPut**](../Model/UserNaturalPut.md)| UserNatural Object params | [optional]

### Return type

[**\MarketPay\Model\UserNaturalResponse**](../Model/UserNaturalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

