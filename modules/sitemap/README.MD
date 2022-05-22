## Installation

#### Use console
```bash
composer require wezom-cms/sitemap
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/sitemap": "^8.1"
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

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\Sitemap\SitemapServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\Sitemap\SitemapServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Sitemap\SitemapServiceProvider" --tag="lang"
```
