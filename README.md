# emstell-api(CORE PHP)

## NOTE:
`composer dump-autload`
## API end Points

`1. {base_url}/api/product/listings.php -> GET`

`2. {base_url}/api/product/view.php -> GET`

  Params:
    `{
      product_id,
      lang_id 
    }`

`3. {base_url}/api/cart/add.php -> POST`

   Params:
    `{
      product_id,
      lang_id ,
      customer_id
    }`

`4. {base_url}/api/cart/view.php -> GET`

 Params:
    `{
      customer_id,
    }`

`5. {base_url}/api/cart/update.php -> POST`

`6. {base_url}/api/cart/checkout.php -> POST`

Params:
    `{
      product_id,
      lang_id ,
      customer_id,
      quantity:(optional)
    }`
