## Installation

#### Use console
```bash
composer require wezom-cms/ui
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/ui": "^8.1"
}
```
#### Install dependencies:
```bash
composer update
```
#### Package discover
```bash
php artisan package:discover
```
#### Run migrations
```bash
php artisan migrate
```

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\Ui\UiServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\Ui\UiServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Ui\UiServiceProvider" --tag="lang"
```

## Override tinyMCE settings
Copy from `core/resources/views/admin/partials/js/tiny-mce.blade.php` in `resources/views/admin` directory
