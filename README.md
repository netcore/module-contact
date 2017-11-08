## Module for more simple contact page management
Main idea of this module is to provide easy contact page setting management, creating map with location and make contact form.

## Pre-installation

This package is part of Netcore CMS ecosystem and is only functional in a project that has following packages installed:

https://github.com/netcore/netcore

https://github.com/netcore/module-admin

https://github.com/netcore/module-form (Only if you will use contact form)

https://github.com/nWidart/laravel-modules

## Installation

```composer require netcore/module-contact```

Publish config, assets, migrations. Migrate and seed:

```
php artisan module:publish-config Contact
php artisan module:publish Contact
php artisan module:publish-migration Contact
php artisan migrate
php artisan module:seed Contact
```
You should be good to go.

## Usage

After setup new section will appear in your acp. The name of the section will be "Contact"
If your project do not need map or some other settings you can disable them in your configuration file - `config/netcore/module-contact.php`

You get `contact()` helper. With the helper you can access all features from contact module.

## Examples
To return all data necessary for map:
```contact()->map()```

To return content text:

```contact()->content()```

To return contact settings:

```
contact()->item('phone')
contact()->item('workdays')
contact()->item('location')
contact()->item('contact-email')
contact()->item('contact-form')
```

