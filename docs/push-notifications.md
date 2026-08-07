## Push Notifications

The `Device` model implements Laravel's `Notifiable` contract and includes a `routeNotificationForFcm()` method for routing Firebase Cloud Messaging (FCM) notifications.

### Sending a Notification

Use Laravel's notification system with an FCM notification channel:

```php
use Illuminate\Notifications\Notification;

$device->notify(new OrderShipped($order));
```

The `routeNotificationForFcm()` method returns the device's `token` field, which is used by FCM notification channels to deliver the push notification to the correct device.

### Database Schema

The devices table stores the FCM token per device:

| Column | Type | Description |
|---|---|---|
| `token` | string | The FCM push notification token |
| `type` | string | Device type (`web` or `mobile`) |
| `platform` | string, nullable | Platform name |
| `identifier` | string, nullable | Device identifier such as a UUID |
| `deviceable_id` | integer | Polymorphic owner ID |
| `deviceable_type` | string | Polymorphic owner type |
