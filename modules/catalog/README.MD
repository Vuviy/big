## Installation

#### Use console
```bash
composer require wezom-cms/catalog
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/catalog": "^8.1"
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
#### Assets
```bash
php artisan vendor:publish --provider="WezomCms\Catalog\CatalogServiceProvider" --tag="assets" --force
```
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\Catalog\CatalogServiceProvider" --tag="views"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Catalog\CatalogServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Catalog\CatalogServiceProvider" --tag="migrations"
```
