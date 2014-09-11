## Shopify Webhooks

Backend project to add and list webhooks for a Shopify store.

## Installation

*Note:* The app is built on the development branch of Laravel 4.3, 2 months or
more before the branch is stable and 4.3 is released. Laravel 4.3 might change
things before the final release, and the app will then need to be adjusted
accordingly.

1. Configure your Laravel environments in bootstrap/environment.php
2. Setup your database in config/database.php
3. Run migrations
4. Setup your new app in Shopify. For callback URL in the app, it needs to be an URL in the same domain as the Laravel app is installed.
5. Set the Shopify app credentials in config/shopify.php.
6. Ready to go.
