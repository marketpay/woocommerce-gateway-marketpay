# UniversalPayPayByWebPost

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**debited_funds** | [**\Swagger\Client\Model\Money**](Money.md) | Information about the funds that are being debited | 
**fees** | [**\Swagger\Client\Model\Money**](Money.md) | Information about the fees that were taken by the client for this transaction (and were hence transferred to the Client&#39;s platform wallet) | 
**card_id** | **string** | The id of a previous saved card. SaveCard and CardId are mutually exclusive | [optional] 
**save_card** | **bool** | Whether to save or not the card for future use. SaveCard and CardId are mutually exclusive | [optional] 
**statement_descriptor** | **string** |  | 
**tag** | **string** | Custom data that you can add to this item | [optional] 
**credited_wallet_id** | **string** | The ID of the wallet where money will be credited | 
**secure_mode** | **string** |  | [optional] 
**success_url** | **string** | Url to redirect the browser in case the payment is completed successfully | [optional] 
**cancel_url** | **string** | Url to redirect the browser in case the payment is not completed successfully | [optional] 
**language** | **string** | Valid values are ES, EN, FR | [optional] 
**customer** | [**\Swagger\Client\Model\CustomerDetail**](CustomerDetail.md) |  | 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


