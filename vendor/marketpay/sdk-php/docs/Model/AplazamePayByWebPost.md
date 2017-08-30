# AplazamePayByWebPost

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**tag** | **string** | Custom data that you can add to this item | [optional] 
**user_id** | **int** | Whether to save or not the card for future use. SaveCard and CardId are mutually exclusive | [optional] 
**credited_wallet_id** | **string** | The ID of the wallet where money will be credited | [optional] 
**debited_funds** | [**\Swagger\Client\Model\Money**](Money.md) | Information about the funds that are being debited | 
**fees** | [**\Swagger\Client\Model\Money**](Money.md) | Information about the fees that were taken by the client for this transaction (and were hence transferred to the Client&#39;s platform wallet) | [optional] 
**shipping** | [**\Swagger\Client\Model\Money**](Money.md) |  | [optional] 
**cancel_url** | **string** | Dirección (relativa a la tienda) a la que redirigirá en caso de error en el pago. | 
**success_url** | **string** | Dirección (relativa a la tienda) a la que redirigirá cuando se haya completado el pago. | 
**checkout_url** | **string** | Dirección a la que se redirigirá el usuario si escoge volver a la tienda (por omisión &#39;/&#39;). | [optional] 
**order_items** | [**\Swagger\Client\Model\AplazameOrderItem[]**](AplazameOrderItem.md) |  | 
**customer** | [**\Swagger\Client\Model\Customer**](Customer.md) | Customer data. | 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


