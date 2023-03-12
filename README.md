# Ycode Test Assignment.

Ycode is being used as internal dashboard for managing orders of an e-shop. Here's an example:
https://orders.ycodeapp.com.

Your task is to build an external orders page that would submit orders through Ycode API and save them to the database, so that the team could see them in the dashboard like in the example.

We've provided a starting point for your checkout form's HTML.

We've also created a Ycode project for you to clone, complete with collections you'll need to interact with via the Ycode API.

Use small commits and descriptive commit messages while working on the assignment. One commit solving one issue.

We expect you to demonstrate both your back-end and front-end skills.

Please do the following before starting to get setup:

1. Sign up for a Ycode account by following the link https://app.ycode.com/register, or login if you already have one.
2. Clone the project you will need for the test by visiting this link https://2241b135-25c6-413d-98ba-5e4048f59d5b-app15392.ycodeapp.com/ and clicking "Clone project". This should then redirect you into this project on your account.
3. Generate an API key for your cloned project. This is what you will need to interact with the Ycode API. You can find instructions here: https://developers.ycode.com/docs


---

Use this repository as your starting point but **DO NOT** fork it. Create a private repository on GitHub for your application source code, push it and invite the username of "liamwalder" as a collaborator via "Settings > Access > Collaborators".


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
