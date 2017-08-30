# BankAccountResponseCa

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**branch_code** | **string** | The branch code of the bank where the bank account. Must be numbers only, and 5 digits long | [optional] 
**institution_number** | **string** | The institution number of the bank account. Must be numbers only, and 3 or 4 digits long | [optional] 
**account_number** | **string** | The account number of the bank account. Must be numbers only. Canadian account numbers must be a maximum of 20 digits | [optional] 
**bank_name** | **string** | The name of the bank where the account is held. Must be letters or numbers only and maximum 50 characters long | [optional] 
**type** | **string** | The type of bank account | [optional] 
**owner_address** | [**\Swagger\Client\Model\Address**](Address.md) | The address of the owner of the bank account | [optional] 
**owner_name** | **string** | The name of the owner of the bank account | [optional] 
**user_id** | **string** | The object owner&#39;s UserId | [optional] 
**active** | **bool** | Whether the bank account is active or not | [optional] 
**id** | **string** | The item&#39;s ID | [optional] 
**creation_date** | **int** | When the item was created | [optional] 
**tag** | **string** | Custom data that you can add to this item | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


