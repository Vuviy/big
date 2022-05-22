## Installation

#### Use console
```bash
composer require wezom-cms/menu
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/menu": "^8.1"
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
#### Assets
```bash
php artisan vendor:publish --provider="WezomCms\Menu\MenuServiceProvider" --tag="assets"
```
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\Menu\MenuServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\Menu\MenuServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Menu\MenuServiceProvider" --tag="lang"
```
