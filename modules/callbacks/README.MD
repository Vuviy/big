## Installation

#### Use console
```bash
composer require wezom-cms/callbacks
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/callbacks": "^8.1"
}
```
#### Update dependencies:
```bash
composer update
```
#### Run migrations
```bash
php artisan migrate
```

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\Callbacks\CallbacksServiceProvider" --tag="views"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Callbacks\CallbacksServiceProvider" --tag="migrations"
```

