## Installation

#### Use console
```bash
composer require wezom-cms/privacy-policy
```
#### Or edit composer.json
```json
"require": {
    ...
    "wezom-cms/privacy-policy": "^8.1"
}
```
#### Update dependencies:
```bash
composer update
```

## Publish
#### Views
```bash
php artisan vendor:publish --provider="WezomCms\PrivacyPolicy\PrivacyPolicyServiceProvider" --tag="views"
```
#### Lang
```bash
php artisan vendor:publish --provider="WezomCms\PrivacyPolicy\PrivacyPolicyServiceProvider" --tag="lang"
```

