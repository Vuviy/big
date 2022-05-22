## Installation

#### Use console
```bash
composer require wezom-cms/about
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/about": "^8.1"
}
```
#### Update dependencies:
```bash
composer update
```

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\About\AboutServiceProvider" --tag="views"
```
