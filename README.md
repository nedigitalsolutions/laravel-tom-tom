# laravel-tom-tom

API Client for Laravel 5 that connects with TomTom's Webfleet .Connect API.

Currently supported calls:

- createSession
- showUsers
- showObjectReport
- showVehicleReport
- sendOrder
- sendDestinationOrder
- showAddressReport
- insertAddress
- updateAddress
- deleteAddress

It is also relatively easy to add your own methods quickly, please submit a PR with any improvements.

**Still heavily in development and probably shouldn't be used in a commercial project.**

# Installation

Run the following command in your Laravel installation.

```composer require hirealite/laravel-tom-tom```

Once its installed add the following provider to your config.php:

```Hirealite\LaravelTomTom\TomTomServiceProvider::class```

And the Facade:

```'TomTom' => \Hirealite\LaravelTomTom\Facades\TomTom::class,```

then run the following command to generate the configuration file:

```php artisan vendor:publish```

You'll then need to add your TomTom API into the ```config/tomtom.php``` file.