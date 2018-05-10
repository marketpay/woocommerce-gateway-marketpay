# KycUserNaturalPut

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**email** | **string** | The user&#39;s email address - must be a valid email | [optional] 
**first_name** | **string** | The name of the user | [optional] 
**last_name** | **string** | The last name of the user | [optional] 
**address** | [**\MarketPay\Model\Address**](Address.md) | The address | [optional] 
**birthday** | **int** | The date of birth of the user - be careful to set the right timezone (should be UTC) to avoid 00h becoming 23h (and hence interpreted as the day before) | [optional] 
**nationality** | **string** | The user’s nationality. ISO 3166-1 alpha-2 format is expected | [optional] 
**country_of_residence** | **string** | The user’s country of residence. ISO 3166-1 alpha-2 format is expected | [optional] 
**occupation** | **string** | User’s occupation, ie. Work | [optional] 
**income_range** | **int** | Could be only one of these values: 1 - for incomes &amp;lt;18K€),2 - for incomes between 18 and 30K€, 3 - for incomes between 30 and 50K€, 4 - for incomes between 50 and 80K€, 5 - for incomes between 80 and 120K€, 6 - for incomes &amp;gt;120K€ | [optional] 
**telephone** | [**\MarketPay\Model\Telephone**](Telephone.md) |  | [optional] 
**id_card** | **string** |  | [optional] 
**tag** | **string** | Custom data that you can add to this item | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


