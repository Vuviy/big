## Installation

#### Use console
```bash
composer require wezom-cms/pages
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/pages": "^8.1"
}
```
#### Install dependencies:
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
php artisan vendor:publish --provider="WezomCms\Pages\PagesServiceProvider" --tag="views"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Pages\PagesServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Pages\PagesServiceProvider" --tag="migrations"
```
