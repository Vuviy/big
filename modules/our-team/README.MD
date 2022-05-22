## Installation

#### Use console
```bash
composer require wezom-cms/our-team
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/our-team": "^8.1"
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
php artisan vendor:publish --provider="WezomCms\OurTeam\OurTeamServiceProvider" --tag="views"
```
#### Config
```bash
php artisan vendor:publish --provider="WezomCms\OurTeam\OurTeamServiceProvider" --tag="config"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\OurTeam\OurTeamServiceProvider" --tag="lang"
```
#### Migrations
```bash
php artisan vendor:publish --provider="WezomCms\OurTeam\OurTeamServiceProvider" --tag="migrations"
```
