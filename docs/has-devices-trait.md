## HasDevices Trait

The `HasDevices` trait provides a polymorphic one-to-many relationship from your model to device records.

### Usage

Add the trait to any model that can own devices, typically the `User` model:

```php
use Whilesmart\UserDevices\Traits\HasDevices;

class User extends Authenticatable
{
    use HasDevices;
}
```

### Methods

#### devices()

Returns a `MorphMany` relationship to the `Device` model:

```php
$user->devices(); // Query builder

foreach ($user->devices as $device) {
    // Collection of Device models
}
```

#### getDevicesAttribute()

A convenience accessor that returns the devices collection. Append it to model serialization:

```php
use Whilesmart\UserDevices\Traits\HasDevices;

class User extends Authenticatable
{
    use HasDevices;

    protected $appends = ['devices'];
}
```

#### getDeviceAttribute()

Returns the first device record. Useful when a user is expected to have only one device.

### Creating Devices Through the Relationship

```php
$user->devices()->create([
    'token' => 'fcm-token-here',
    'name' => 'iPhone 15',
    'type' => 'mobile',
    'platform' => 'iOS',
]);
```

### Device Model

The `Device` model uses polymorphic relationships (`deviceable_type` and `deviceable_id`), so any model can own devices. The model is a `Notifiable` and includes a `routeNotificationForFcm()` method for Laravel notification routing.
