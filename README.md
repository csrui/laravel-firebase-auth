# laravel-firebase-auth
Secure your laravel API with Google Firebase Auth

Adding the *Middleware* to your API will ensure that access is granted only using a valid Bearer Token issues by Goggle Firebase Auth.

## Install

```bash
composer require csrui/laravel-firebase-auth
```

Publish the package's config.

```bash
php artisan vendor:publish
```

This will add a firebase.php config file where you need to add you Firebase **Project ID**.

Next add the *Middleware* on your *Kernel.php* file.

```php
\csrui\LaravelFirebaseAuth\Middleware\JWTAuth::class,
```

## Support

Feel free to open issues and provide feedback.