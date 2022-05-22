## Installation

#### Use console
```bash
composer require wezom-cms/seo
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/seo": "^8.1"
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
php artisan vendor:publish --provider="WezomCms\Seo\SeoServiceProvider" --tag="views"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Seo\SeoServiceProvider" --tag="lang"
```

## Issues
If your get error
```
file_exists(): open_basedir restriction in effect. File(/tmp) laravel excel
```
Your need publish LaravelExcel config to config/excel.php & set 'local_path'  => storage_path(),
