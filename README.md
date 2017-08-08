# README #

This README briefly explain about the ETP Web Wallet.

### ETP Web Wallet ###

* An ETP Web Wallet to store, transfer, request and stake ETP Token
* Version 1

### Plugins ###

* JWT Auth - Managing user roles and permissions
	* https://github.com/tymondesigns/jwt-auth/wiki
* Database Abstraction Layer - Database schema introspection, schema management and PDO abstraction
	* https://packagist.org/packages/doctrine/dbal
* Guzzle - Create HTTP Request
	* https://packagist.org/packages/kozz/laravel-guzzle-provider
* Captcha
	* https://github.com/anhskohbo/no-captcha
* Image Intervention - Manage image resizing
	* http://image.intervention.io/getting_started/introduction 

### Project Setup ###

This project is created using Laravel framework. Refer to this [link](https://laravel.com/docs/5.4/installation) for Laravel installation guide.

To start using this template, please follow these steps: 
1. Clone this project 
2. Run: `composer update`
3. Run: `php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"`
4. Run: `php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"`
5. Run: `composer dump-autoload`
6. Run: `php artisan migrate`
7. Run: `php artisan db:seed` 

### Modules ###

There are 7 main modules for this project:

1. Registration
2. Login
3. Dashboard view
4. Transfer ETP
5. Request ETP
6. Stakes
7. Profile