## Installation

#### Use console
```bash
composer require wezom-cms/news
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/news": "^8.1"
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
php artisan vendor:publish --provider="WezomCms\News\NewsServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\News\NewsServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\News\NewsServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\News\NewsServiceProvider" --tag="migrations"
```
