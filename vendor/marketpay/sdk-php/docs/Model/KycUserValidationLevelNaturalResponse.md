# KycUserValidationLevelNaturalResponse

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**email** | **string** | The user&#39;s email address - must be a valid email | [optional] 
**first_name** | **string** | The name of the user | [optional] 
**last_name** | **string** | The last name of the user | [optional] 
**address** | [**\Swagger\Client\Model\Address**](Address.md) | The address | [optional] 
**birthday** | **int** | The date of birth of the user - be careful to set the right timezone (should be UTC) to avoid 00h becoming 23h (and hence interpreted as the day before) | [optional] 
**nationality** | **string** | The user’s nationality. ISO 3166-1 alpha-2 format is expected | [optional] 
**country_of_residence** | **string** | The user’s country of residence. ISO 3166-1 alpha-2 format is expected | [optional] 
**occupation** | **string** | User’s occupation, ie. Work | [optional] 
**telephone** | [**\Swagger\Client\Model\Telephone**](Telephone.md) |  | [optional] 
**id_card** | **string** |  | [optional] 
**id_card_document** | [**\Swagger\Client\Model\KycDocumentDetails**](KycDocumentDetails.md) |  | [optional] 
**person_type** | **string** | Type of user | [optional] 
**id** | **string** | The item&#39;s ID | [optional] 
**creation_date** | **int** | When the item was created | [optional] 
**tag** | **string** | Custom data that you can add to this item | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


