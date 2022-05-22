## Installation

#### Use console
```bash
composer require wezom-cms/newsletter
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/newsletter": "^8.1"
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
> For proper work with `users` module remove `.stub` extension from `user_id` migration and run it

## Usage

```xhtml
<livewire:newsletter.subscribe/>
```

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\Newsletter\NewsletterServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\Newsletter\NewsletterServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Newsletter\NewsletterServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Newsletter\NewsletterServiceProvider" --tag="migrations"
```
