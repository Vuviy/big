## Installation

#### Use console
```bash
composer require wezom-cms/branches
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/branches": "^8.1"
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
php artisan vendor:publish --provider="WezomCms\Branches\BranchesServiceProvider" --tag="views"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Branches\BranchesServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Branches\BranchesServiceProvider" --tag="migrations"
```
