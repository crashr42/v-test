# Url shorter

# Docker

Run application with docker containers `bin/docker`. 

Wait container build and server start:

```
PHP 5.6.30 Development Server started at Wed Mar  1 13:43:29 2017
Listening on http://0.0.0.0:8000
```

Open http://0.0.0.0:8000;

# Installation

- install composer and run `composer install`
- rename .env.example to .env
- generate APP_KEY with `php artisan key:generate`
- change database credentials: DB_DATABASE, DB_USERNAME, DB_PASSWORD
- setup migrations with `php artisan migrate`

# Running

Run `php artisan serve`.

# Tests

Run `vendor/bin/phpunit`.
