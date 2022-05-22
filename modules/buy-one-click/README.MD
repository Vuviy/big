## Installation

#### Use console
```bash
composer require wezom-cms/buy-one-click
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/buy-one-click": "^8.1"
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
> For proper work with `users` module remove `.stub` extension from `user_id` migration and run it

## Usage

Place livewire tag and pass Product object

```xhtml
<livewire:buy-one-click.product-button :product="$product" />
```

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\BuyOneClick\BuyOneClickServiceProvider" --tag="views"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\BuyOneClick\BuyOneClickServiceProvider" --tag="migrations"
```

