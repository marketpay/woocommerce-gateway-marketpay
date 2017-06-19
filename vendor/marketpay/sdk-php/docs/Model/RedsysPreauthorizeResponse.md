# RedsysPreauthorizeResponse

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**debited_funds** | [**\Swagger\Client\Model\Money**](Money.md) | Information about the funds that are being debited | [optional] 
**status** | **string** | The status of the transaction | [optional] 
**payment_status** | **string** | Status of the payment | [optional] 
**execution_date** | **int** | When the transaction happened | [optional] 
**result_code** | **string** | The result code | [optional] 
**result_message** | **string** | A verbal explanation of the ResultCode | [optional] 
**execution_type** | **string** | The type of execution for the payin | [optional] 
**card_id** | **string** | The Id of the card saved, if any. | [optional] 
**statement_descriptor** | **string** | A custom description to appear on the user&#39;s bank statement. It can be up to 10 characters long, and can only include alphanumeric characters or spaces | [optional] 
**author_id** | **string** | A user&#39;s ID | [optional] 
**pay_in_id** | **string** | The Id of the associated PayIn | [optional] 
**language** | **string** |  | [optional] 
**provider** | [**\Swagger\Client\Model\PreauthorizationRedsysData**](PreauthorizationRedsysData.md) | Redsys related data | [optional] 
**id** | **string** |  | [optional] 
**creation_date** | **int** |  | [optional] 
**tag** | **string** |  | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


