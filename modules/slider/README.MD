## Installation

#### Use console
```bash
composer require wezom-cms/slider
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/slider": "^8.1"
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
php artisan vendor:publish --provider="WezomCms\Slider\SliderServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\Slider\SliderServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Slider\SliderServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Slider\SliderServiceProvider" --tag="migrations"
```
