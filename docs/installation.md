## Installation

Install the package via Composer:

```bash
composer require whilesmart/laravel-user-devices
```

### Configuration

Publish the configuration to customize table name and route prefix:

```bash
php artisan vendor:publish --tag=laravel-user-devices-config
```

### Migrations

Run the migrations to create the devices table:

```bash
php artisan migrate
```

To publish and modify the migrations before running:

```bash
php artisan vendor:publish --tag=laravel-user-devices-migrations
php artisan migrate
```

### Publishing Routes

If you need to customize the routes, publish them and require the file in your `routes/api.php`:

```bash
php artisan vendor:publish --tag=laravel-user-devices-routes
```

```php
// routes/api.php
require 'user-devices.php';
```

### Publishing Controllers

To customise the controller logic (for example, to assign devices to a different model):

```bash
php artisan vendor:publish --tag=laravel-user-devices-controllers
```

### Publishing Everything

```bash
php artisan vendor:publish --tag=laravel-user-devices
php artisan migrate
```
