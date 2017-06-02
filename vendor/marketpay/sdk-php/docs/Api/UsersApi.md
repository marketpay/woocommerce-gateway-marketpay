# Swagger\Client\UsersApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**usersGet**](UsersApi.md#usersGet) | **GET** /v2.01/Users/{UserId} | View a User
[**usersGetBankAccount**](UsersApi.md#usersGetBankAccount) | **GET** /v2.01/Users/{UserId}/bankaccounts/{BankAccountId} | View a Bank Account
[**usersGetBankAccountList**](UsersApi.md#usersGetBankAccountList) | **GET** /v2.01/Users/{UserId}/bankaccounts | List Bank Accounts for a User
[**usersGetCardList**](UsersApi.md#usersGetCardList) | **GET** /v2.01/Users/{UserId}/cards | List Cards for a User
[**usersGetLegal**](UsersApi.md#usersGetLegal) | **GET** /v2.01/Users/legal/{UserId} | View a Legal User
[**usersGetList**](UsersApi.md#usersGetList) | **GET** /v2.01/Users | List all Users
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
> \Swagger\Client\Model\UserResponse usersGet($user_id)

View a User

A User can be \"Natural\" or \"Legal\". With a UserId, you are able to:              Fetch a user and get their details              List all the wallets of a user              Get all your users in a list

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user

try {
    $result = $api_instance->usersGet($user_id);
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

[**\Swagger\Client\Model\UserResponse**](../Model/UserResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetBankAccount**
> \Swagger\Client\Model\BankAccountResponse usersGetBankAccount($user_id, $bank_account_id)

View a Bank Account



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 56; // int | The Id of a user
$bank_account_id = 56; // int | The Id of a bank account

try {
    $result = $api_instance->usersGetBankAccount($user_id, $bank_account_id);
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

[**\Swagger\Client\Model\BankAccountResponse**](../Model/BankAccountResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetBankAccountList**
> \Swagger\Client\Model\BankAccountResponse[] usersGetBankAccountList($user_id, $page, $per_page)

List Bank Accounts for a User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $api_instance->usersGetBankAccountList($user_id, $page, $per_page);
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

[**\Swagger\Client\Model\BankAccountResponse[]**](../Model/BankAccountResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetCardList**
> \Swagger\Client\Model\CardResponse[] usersGetCardList($user_id, $page, $per_page)

List Cards for a User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $api_instance->usersGetCardList($user_id, $page, $per_page);
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

[**\Swagger\Client\Model\CardResponse[]**](../Model/CardResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetLegal**
> \Swagger\Client\Model\UserLegalResponse usersGetLegal($user_id)

View a Legal User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a legal user

try {
    $result = $api_instance->usersGetLegal($user_id);
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

[**\Swagger\Client\Model\UserLegalResponse**](../Model/UserLegalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetList**
> \Swagger\Client\Model\UserResponse[] usersGetList($page, $per_page)

List all Users



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $api_instance->usersGetList($page, $per_page);
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

[**\Swagger\Client\Model\UserResponse[]**](../Model/UserResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetNatural**
> \Swagger\Client\Model\UserNaturalResponse usersGetNatural($user_id)

View a Natural User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a natural user

try {
    $result = $api_instance->usersGetNatural($user_id);
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

[**\Swagger\Client\Model\UserNaturalResponse**](../Model/UserNaturalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetTransactionList**
> \Swagger\Client\Model\TransactionResponse[] usersGetTransactionList($user_id, $page, $per_page)

List Transactions for a User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $api_instance->usersGetTransactionList($user_id, $page, $per_page);
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

[**\Swagger\Client\Model\TransactionResponse[]**](../Model/TransactionResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersGetWalletList**
> \Swagger\Client\Model\WalletResponse[] usersGetWalletList($user_id, $page, $per_page)

List Wallets for a User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$page = 56; // int | The page number of results you wish to return
$per_page = 56; // int | The number of results to return per page

try {
    $result = $api_instance->usersGetWalletList($user_id, $page, $per_page);
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

[**\Swagger\Client\Model\WalletResponse[]**](../Model/WalletResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountCa**
> \Swagger\Client\Model\BankAccountResponseCa usersPostBankAccountCa($user_id, $bank_account_ca)

Create a CA BankAccount

In the case of CAD PayOut, the author (AuthorId) of the PayOut should have their address (Address for Natural Users or HeaquartersAddress for Legal Users) completed in their User object

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$bank_account_ca = new \Swagger\Client\Model\BankAccountCaPost(); // \Swagger\Client\Model\BankAccountCaPost | BankAccountCA Object params

try {
    $result = $api_instance->usersPostBankAccountCa($user_id, $bank_account_ca);
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
 **bank_account_ca** | [**\Swagger\Client\Model\BankAccountCaPost**](../Model/\Swagger\Client\Model\BankAccountCaPost.md)| BankAccountCA Object params | [optional]

### Return type

[**\Swagger\Client\Model\BankAccountResponseCa**](../Model/BankAccountResponseCa.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountGb**
> \Swagger\Client\Model\BankAccountResponseGb usersPostBankAccountGb($user_id, $bank_account_gb)

Create a GB BankAccount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$bank_account_gb = new \Swagger\Client\Model\BankAccountGbPost(); // \Swagger\Client\Model\BankAccountGbPost | 

try {
    $result = $api_instance->usersPostBankAccountGb($user_id, $bank_account_gb);
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
 **bank_account_gb** | [**\Swagger\Client\Model\BankAccountGbPost**](../Model/\Swagger\Client\Model\BankAccountGbPost.md)|  | [optional]

### Return type

[**\Swagger\Client\Model\BankAccountResponseGb**](../Model/BankAccountResponseGb.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountIban**
> \Swagger\Client\Model\BankAccountResponseIban usersPostBankAccountIban($user_id, $bank_account_iban)

Create an IBAN BankAccount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$bank_account_iban = new \Swagger\Client\Model\BankAccountIbanPost(); // \Swagger\Client\Model\BankAccountIbanPost | BankAccountIBAN Object params

try {
    $result = $api_instance->usersPostBankAccountIban($user_id, $bank_account_iban);
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
 **bank_account_iban** | [**\Swagger\Client\Model\BankAccountIbanPost**](../Model/\Swagger\Client\Model\BankAccountIbanPost.md)| BankAccountIBAN Object params | [optional]

### Return type

[**\Swagger\Client\Model\BankAccountResponseIban**](../Model/BankAccountResponseIban.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountOther**
> \Swagger\Client\Model\BankAccountResponseOther usersPostBankAccountOther($user_id, $bank_account_other)

Create an OTHER BankAccount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$bank_account_other = new \Swagger\Client\Model\BankAccountOtherPost(); // \Swagger\Client\Model\BankAccountOtherPost | 

try {
    $result = $api_instance->usersPostBankAccountOther($user_id, $bank_account_other);
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
 **bank_account_other** | [**\Swagger\Client\Model\BankAccountOtherPost**](../Model/\Swagger\Client\Model\BankAccountOtherPost.md)|  | [optional]

### Return type

[**\Swagger\Client\Model\BankAccountResponseOther**](../Model/BankAccountResponseOther.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostBankAccountUs**
> \Swagger\Client\Model\BankAccountResponseUs usersPostBankAccountUs($user_id, $bank_account_us)

Create an US BankAccount

In the case of USD PayOut, the author (AuthorId) of the PayOut should have their address (Address for Natural Users or HeaquartersAddress for Legal Users) completed in their User object.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$bank_account_us = new \Swagger\Client\Model\BankAccountUsPost(); // \Swagger\Client\Model\BankAccountUsPost | BankAccountUS Object params

try {
    $result = $api_instance->usersPostBankAccountUs($user_id, $bank_account_us);
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
 **bank_account_us** | [**\Swagger\Client\Model\BankAccountUsPost**](../Model/\Swagger\Client\Model\BankAccountUsPost.md)| BankAccountUS Object params | [optional]

### Return type

[**\Swagger\Client\Model\BankAccountResponseUs**](../Model/BankAccountResponseUs.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostLegal**
> \Swagger\Client\Model\UserLegalResponse usersPostLegal($user_legal)

Create a Legal User

Note that the LegalRepresentativeBirthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_legal = new \Swagger\Client\Model\UserLegalPost(); // \Swagger\Client\Model\UserLegalPost | UserLegal Object params

try {
    $result = $api_instance->usersPostLegal($user_legal);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostLegal: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_legal** | [**\Swagger\Client\Model\UserLegalPost**](../Model/\Swagger\Client\Model\UserLegalPost.md)| UserLegal Object params | [optional]

### Return type

[**\Swagger\Client\Model\UserLegalResponse**](../Model/UserLegalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPostNatural**
> \Swagger\Client\Model\UserNaturalResponse usersPostNatural($user_natural)

Create a Natural User

Note that the Birthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_natural = new \Swagger\Client\Model\UserNaturalPost(); // \Swagger\Client\Model\UserNaturalPost | UserNatural Object params

try {
    $result = $api_instance->usersPostNatural($user_natural);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->usersPostNatural: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_natural** | [**\Swagger\Client\Model\UserNaturalPost**](../Model/\Swagger\Client\Model\UserNaturalPost.md)| UserNatural Object params | [optional]

### Return type

[**\Swagger\Client\Model\UserNaturalResponse**](../Model/UserNaturalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPutLegal**
> \Swagger\Client\Model\UserLegalResponse usersPutLegal($user_id, $user_legal)

Update a Legal User

Note that the LegalRepresentativeBirthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$user_legal = new \Swagger\Client\Model\UserLegalPut(); // \Swagger\Client\Model\UserLegalPut | UserLegal Object params

try {
    $result = $api_instance->usersPutLegal($user_id, $user_legal);
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
 **user_legal** | [**\Swagger\Client\Model\UserLegalPut**](../Model/\Swagger\Client\Model\UserLegalPut.md)| UserLegal Object params | [optional]

### Return type

[**\Swagger\Client\Model\UserLegalResponse**](../Model/UserLegalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersPutNatural**
> \Swagger\Client\Model\UserNaturalResponse usersPutNatural($user_id, $user_natural)

Update a Natural User

Note that the Birthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\UsersApi();
$user_id = 789; // int | The Id of a user
$user_natural = new \Swagger\Client\Model\UserNaturalPut(); // \Swagger\Client\Model\UserNaturalPut | UserNatural Object params

try {
    $result = $api_instance->usersPutNatural($user_id, $user_natural);
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
 **user_natural** | [**\Swagger\Client\Model\UserNaturalPut**](../Model/\Swagger\Client\Model\UserNaturalPut.md)| UserNatural Object params | [optional]

### Return type

[**\Swagger\Client\Model\UserNaturalResponse**](../Model/UserNaturalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json, text/json, application/json-patch+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

