# Swagger\Client\KycApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**kycGetLegal**](KycApi.md#kycGetLegal) | **GET** /v2.01/Kyc/users/legal/{UserId} | View a Legal User
[**kycGetNatural**](KycApi.md#kycGetNatural) | **GET** /v2.01/Kyc/users/natural/{UserId} | View a Natural User
[**kycGetValidaton**](KycApi.md#kycGetValidaton) | **GET** /v2.01/Kyc/users/natural/{UserId}/validation | 
[**kycPostDocument**](KycApi.md#kycPostDocument) | **POST** /v2.01/Kyc/users/{UserId}/documents/new/{DocumentType} | Uploads a new document and uploads a file. If the document already exists it will be replaced.
[**kycPostNatural**](KycApi.md#kycPostNatural) | **POST** /v2.01/Kyc/users/natural/{UserId} | Update a Natural User Kyc Data
[**kycPutDocument**](KycApi.md#kycPutDocument) | **PUT** /v2.01/Kyc/users/{UserId}/documents/add/{DocumentType} | Adds files to a document.
[**kycPutLegal**](KycApi.md#kycPutLegal) | **POST** /v2.01/Kyc/users/legal/{UserId} | Update a Legal User
[**kycPutRequest**](KycApi.md#kycPutRequest) | **PUT** /v2.01/Kyc/users/natural/{UserId}/requestValidation | 


# **kycGetLegal**
> \Swagger\Client\Model\KycUserValidationLevelLegalResponse kycGetLegal($user_id)

View a Legal User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\KycApi();
$user_id = 789; // int | The Id of a legal user

try {
    $result = $api_instance->kycGetLegal($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KycApi->kycGetLegal: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a legal user |

### Return type

[**\Swagger\Client\Model\KycUserValidationLevelLegalResponse**](../Model/KycUserValidationLevelLegalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **kycGetNatural**
> \Swagger\Client\Model\KycUserValidationLevelNaturalResponse kycGetNatural($user_id)

View a Natural User



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\KycApi();
$user_id = 789; // int | The Id of a natural user

try {
    $result = $api_instance->kycGetNatural($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KycApi->kycGetNatural: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a natural user |

### Return type

[**\Swagger\Client\Model\KycUserValidationLevelNaturalResponse**](../Model/KycUserValidationLevelNaturalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **kycGetValidaton**
> \Swagger\Client\Model\KycValidationUserStatusResponse kycGetValidaton($user_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\KycApi();
$user_id = 789; // int | 

try {
    $result = $api_instance->kycGetValidaton($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KycApi->kycGetValidaton: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**|  |

### Return type

[**\Swagger\Client\Model\KycValidationUserStatusResponse**](../Model/KycValidationUserStatusResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **kycPostDocument**
> \Swagger\Client\Model\KycFileUploadResponse kycPostDocument($document_type, $file, $user_id, $file_content_type)

Uploads a new document and uploads a file. If the document already exists it will be replaced.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\KycApi();
$document_type = "document_type_example"; // string | 
$file = "/path/to/file.txt"; // \SplFileObject | 
$user_id = 789; // int | 
$file_content_type = "file_content_type_example"; // string | Mime type of the uploaded file. This parameter overrides the type associated to the file.

try {
    $result = $api_instance->kycPostDocument($document_type, $file, $user_id, $file_content_type);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KycApi->kycPostDocument: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **document_type** | **string**|  |
 **file** | **\SplFileObject**|  |
 **user_id** | **int**|  |
 **file_content_type** | **string**| Mime type of the uploaded file. This parameter overrides the type associated to the file. | [optional]

### Return type

[**\Swagger\Client\Model\KycFileUploadResponse**](../Model/KycFileUploadResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: multipart/form-data
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **kycPostNatural**
> \Swagger\Client\Model\KycUserValidationLevelNaturalResponse kycPostNatural($user_id, $kyc_user_natural)

Update a Natural User Kyc Data

Note that the Birthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\KycApi();
$user_id = 789; // int | The Id of a user
$kyc_user_natural = new \Swagger\Client\Model\KycUserNaturalPut(); // \Swagger\Client\Model\KycUserNaturalPut | UserNatural Kyc detail params

try {
    $result = $api_instance->kycPostNatural($user_id, $kyc_user_natural);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KycApi->kycPostNatural: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **kyc_user_natural** | [**\Swagger\Client\Model\KycUserNaturalPut**](../Model/KycUserNaturalPut.md)| UserNatural Kyc detail params | [optional]

### Return type

[**\Swagger\Client\Model\KycUserValidationLevelNaturalResponse**](../Model/KycUserValidationLevelNaturalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **kycPutDocument**
> \Swagger\Client\Model\KycFileUploadResponse kycPutDocument($document_type, $file, $user_id, $file_content_type)

Adds files to a document.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\KycApi();
$document_type = "document_type_example"; // string | 
$file = "/path/to/file.txt"; // \SplFileObject | 
$user_id = 789; // int | 
$file_content_type = "file_content_type_example"; // string | Mime type of the uploaded file. This parameter overrides the type associated to the file.

try {
    $result = $api_instance->kycPutDocument($document_type, $file, $user_id, $file_content_type);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KycApi->kycPutDocument: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **document_type** | **string**|  |
 **file** | **\SplFileObject**|  |
 **user_id** | **int**|  |
 **file_content_type** | **string**| Mime type of the uploaded file. This parameter overrides the type associated to the file. | [optional]

### Return type

[**\Swagger\Client\Model\KycFileUploadResponse**](../Model/KycFileUploadResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: multipart/form-data
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **kycPutLegal**
> \Swagger\Client\Model\KycUserValidationLevelLegalResponse kycPutLegal($user_id, $user_legal)

Update a Legal User

Note that the LegalRepresentativeBirthday field is a timestamp, but be careful to ensure that the time is midnight UTC (otherwise a local time can be understood as 23h UTC, and therefore rendering the wrong date which will present problems when needing to validate the KYC identity)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\KycApi();
$user_id = 789; // int | The Id of a user
$user_legal = new \Swagger\Client\Model\KycUserLegalPut(); // \Swagger\Client\Model\KycUserLegalPut | UserLegal Object params

try {
    $result = $api_instance->kycPutLegal($user_id, $user_legal);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KycApi->kycPutLegal: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| The Id of a user |
 **user_legal** | [**\Swagger\Client\Model\KycUserLegalPut**](../Model/KycUserLegalPut.md)| UserLegal Object params | [optional]

### Return type

[**\Swagger\Client\Model\KycUserValidationLevelLegalResponse**](../Model/KycUserValidationLevelLegalResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **kycPutRequest**
> \Swagger\Client\Model\KycValidationRequestResponse kycPutRequest($user_id, $validation_request)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth2
Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new Swagger\Client\Api\KycApi();
$user_id = 789; // int | 
$validation_request = new \Swagger\Client\Model\KycIdentificationRequest(); // \Swagger\Client\Model\KycIdentificationRequest | 

try {
    $result = $api_instance->kycPutRequest($user_id, $validation_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KycApi->kycPutRequest: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**|  |
 **validation_request** | [**\Swagger\Client\Model\KycIdentificationRequest**](../Model/KycIdentificationRequest.md)|  | [optional]

### Return type

[**\Swagger\Client\Model\KycValidationRequestResponse**](../Model/KycValidationRequestResponse.md)

### Authorization

[oauth2](../../README.md#oauth2)

### HTTP request headers

 - **Content-Type**: application/json-patch+json, application/json, text/json, application/_*+json
 - **Accept**: text/plain, application/json, text/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

