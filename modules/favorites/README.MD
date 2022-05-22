## Installation

#### Use console
```bash
composer require wezom-cms/favorites
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/favorites": "^8.1"
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

## Configure Favorable model
The model that will be added to favorites must implement the interface `WezomCms\Favorites\Contracts\Favorable`.

There is also a trait `WezomCms\Favorites\Traits\FavorableTrait` that implements `Favorable` interface.

Example:
```php
class Product extends \Illuminate\Database\Eloquent\Model implements \WezomCms\Favorites\Contracts\Favorable
{
    use \WezomCms\Favorites\Traits\FavorableTrait;
}
```

## Usage

```xhtml
<livewire:favorites.header-button/>
```

```xhtml
<livewire:favorites.mobile-header-button/>
```

Tag for product page

```xhtml
<livewire:favorites.product-button :favorable="$product" />
```

Widget for product list item

```php
@widget('favorites:product-list-button', ['product' => $product, 'showFavoritesCheck' => $showFavoritesCheck ?? false])
```

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\Favorites\FavoritesServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\Favorites\FavoritesServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\Favorites\FavoritesServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\Favorites\FavoritesServiceProvider" --tag="migrations"
```
