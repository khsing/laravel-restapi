# laravel-restapi

## Intro

This package make OAuth2.0 client credentials able to assign User.

### Feature

- client ID support Hashids to encrypt real ID.

## Installation

* Require this package

```
composer require khsing/laravel-restapi
```

* modify `config/app.php`, add it `providers` with following lines

```
Khsing\Restapi\OAuth2ServiceProvider::class,
Khsing\Restapi\RestapiServiceProvider::class,

```

* execute `php artisan migrate`
* execute `php artisan vendor:publish`

* Need follow [laravel/passport](https://github.com/laravel/passport) setup

## Configuare

Support following configure options.

- `enable_hashids`, boolean, true/false
- `hashids_salt`, salt of hashids, NEED REPLACE WITH YOURS.
- `hashids_length`, length of hashids
- `hashids_alphabet`, alphabet of hashids

## Usage

- create a client app id and secret.

```
php artisan passport:client
```

fill user id, client name and get client secret.

- Modify `routes/api.php`

```
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
```

Now, access `/api/user` will get user's infomation.

btw. Postman is great tools. And the most great part is it's free.

## Intergrate with Dingo/api

- install dingo/api, `composer require dingo/api:1.0.*@dev`
- add dingo to `providers`
- `php artisan vendor:publish`
- add service provider to `config/app.php`, `Khsing\Restapi\DingoAuthServiceProvider::class,`
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

```
    'auth' => [
        'restapi' => \Khsing\Restapi\DingoAuthServiceProvider::class,
    ]
```


## License

This library following MIT License, please keep License file.

## Contact

Guixing:

- Twitter: [https://twitter.com/khsing](https://twitter.com/khsing)
- Email: khsing.cn__AT__.gmail.com

