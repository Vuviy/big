## Installation

#### Or use console
```bash
composer require wezom-cms/faq
```
#### edit composer.json
```json
"require": {
    ...
    "wezom-cms/faq": "^8.1"
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
php artisan vendor:publish --provider="WezomCms\Faq\FaqServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\Faq\FaqServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Faq\FaqServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Faq\FaqServiceProvider" --tag="migrations"
```
