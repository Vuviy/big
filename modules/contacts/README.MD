## Installation

#### Use console
```bash
composer require wezom-cms/contacts
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/contacts": "^8.1"
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
php artisan vendor:publish --provider="WezomCms\Contacts\ContactsServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\Contacts\ContactsServiceProvider" --tag="config"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Contacts\ContactsServiceProvider" --tag="migrations"
```
