# UniversalPayPayInsResponse

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**debited_funds** | [**\Swagger\Client\Model\Money**](Money.md) | Information about the funds that are being debited | [optional] 
**credited_funds** | [**\Swagger\Client\Model\Money**](Money.md) | Details about the funds that are being credited (DebitedFunds – Fees &#x3D; CreditedFunds) | [optional] 
**fees** | [**\Swagger\Client\Model\Money**](Money.md) | Information about the fees that were taken by the client for this transaction (and were hence transferred to the Client&#39;s platform wallet) | [optional] 
**credited_wallet_id** | **string** | The ID of the wallet where money will be credited | [optional] 
**nature** | **string** | The nature of the transaction | [optional] 
**status** | **string** | The status of the transaction | [optional] 
**execution_date** | **int** | When the transaction happened | [optional] 
**result_code** | **string** | The result code | [optional] 
**result_message** | **string** | A verbal explanation of the ResultCode | [optional] 
**type** | **string** | The type of the transaction | [optional] 
**payment_type** | **string** | The type of payin | [optional] 
**execution_type** | **string** | The type of execution for the payin | [optional] 
**statement_descriptor** | **string** | A custom description to appear on the user&#39;s bank statement. It can be up to 10 characters long, and can only include alphanumeric characters or spaces | [optional] 
**author_id** | **string** | A user&#39;s ID | [optional] 
**credited_user_id** | **string** | The user ID who was credited | [optional] 
**provider** | [**\Swagger\Client\Model\PaymentUniversalPayData**](PaymentUniversalPayData.md) |  | [optional] 
**card_id** | **string** |  | [optional] 
**id** | **string** |  | [optional] 
**creation_date** | **int** |  | [optional] 
**tag** | **string** |  | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


