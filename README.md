# laravel-restapi

## Intro

This package make OAuth2.0 client credentials able to assign User.

### Feature

* client ID support Hashids to encrypt real ID.

## Installation

* Require this package

```
composer require khsing/laravel-restapi
```

* modify `config/app.php`, add it `providers` with following lines

```php
Khsing\Restapi\OAuth2ServiceProvider::class,
Khsing\Restapi\RestapiServiceProvider::class,

```

* execute `php artisan migrate`
* execute `php artisan vendor:publish`

* Need follow [laravel/passport](https://github.com/laravel/passport) setup

Since Laravel 5.5 LTS, passport would specific route register, can custom in `app/Providers/AuthServiceProvider.php`

```php
Passport::routes(function ($router) {
    $router->forAccessTokens();
    $router->forTransientTokens();
});
```

## Configuare

Support following configure options.

- `enable_hashids`, boolean, true/false
- `hashids_salt`, salt of hashids, NEED REPLACE WITH YOURS.
- `hashids_length`, length of hashids
- `hashids_alphabet`, alphabet of hashids

## Usage

- create a client app id and secret.

```bash
php artisan passport:client
```

fill user id, client name and get client secret.

- Modify `routes/api.php`

```php
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
```

Now, access `/api/user` will get user's infomation.

btw. Postman is great tools. And the most great part is it's free.

## Intergrate with Dingo/api

- install dingo/api, `composer require dingo/api:2.0.0-alpha1`
- add dingo to `providers`, `Dingo\Api\Provider\LaravelServiceProvider::class,`
- `php artisan vendor:publish`
- modify `app/Http/Kernel.php` with following lines

```php
    protected $middlewareGroups = [
        ...
        'api:auth' => [
            'auth:api',
            'api.auth',
        ],
    ]
```

- modify `config/api.php` auth part

```php
    'auth' => [
        'restapi' => \Khsing\Restapi\DingoAuthServiceProvider::class,
    ]
```

- example of dingo/api, in `routes/api.php` same function

```php
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['middleware' => 'api:auth'], function ($api) {
    $api->get('user', function (Request $request) {
        return $request->user();
    });
});

```


## License

This library following MIT License, please keep License file.

## Contact

Guixing:

- Twitter: [https://twitter.com/khsing](https://twitter.com/khsing)
- Email: khsing.cn__AT__.gmail.com

