## Installation

#### Use console
```bash
composer require wezom-cms/home
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/home": "^8.1"
}
```
#### Update dependencies:
```bash
composer update
```

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\Home\HomeServiceProvider" --tag="views"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Home\HomeServiceProvider" --tag="lang"
```

