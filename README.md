# Commerce

Ycode can be used as internal dashboard for managing orders of an e-shop. Here's an example:
https://orders.ycodeapp.com.

Please do the following before starting to get setup:

1. Sign up for a Ycode account by following the link https://app.ycode.com/register, or login if you already have one.
2. Clone the project you will need for running this app by visiting this link https://2241b135-25c6-413d-98ba-5e4048f59d5b-app15392.ycodeapp.com/ and clicking "Clone project". This should then redirect you into this project on your account.
3. Generate an API key for your cloned project. This is what you will need to interact with the Ycode API. You can find instructions here: https://developers.ycode.com/docs

NOTE:
- In order to run job batches, a db is required, which can be set to use sqlite for fast testing of application
- Migration is needed before hand.
- Assumes that the list of products is only retrieved from first pagination page
- Assumes that order can be deleted before dependent order item holds. This allows for a future job to prune order items
- based on the design, the user will not be able to see the order page immediately when deleted


Requires the following env variables set, which is used by services config file in config/services.php

YCODE_TOKEN

YCODE_COLLECTIONS_PRODUCTS_ID

YCODE_COLLECTIONS_ORDERS_ID

YCODE_COLLECTIONS_ORDER_ITEMS_ID
