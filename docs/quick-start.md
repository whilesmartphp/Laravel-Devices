## Quick Start

### 1. Add the Trait to Your User Model

```php
use Whilesmart\UserDevices\Traits\HasDevices;

class User extends Authenticatable
{
    use HasDevices;
}
```

### 2. Register a Device

```bash
curl -X POST /api/devices \
  -H "Authorization: Bearer $token" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "fcm-token-here",
    "name": "Chrome on Windows",
    "type": "web",
    "identifier": "uuid-or-other-id",
    "platform": "Windows"
  }'
```

### 3. List Devices

```bash
curl -H "Authorization: Bearer $token" /api/devices
```

### 4. Update a Device Token

By ID:

```bash
curl -X PUT /api/devices/1 \
  -H "Authorization: Bearer $token" \
  -H "Content-Type: application/json" \
  -d '{"token": "new-fcm-token"}'
```

By identifier (UUID):

```bash
curl -X PUT /api/devices/identifier/abc-123 \
  -H "Authorization: Bearer $token" \
  -H "Content-Type: application/json" \
  -d '{"token": "new-fcm-token"}'
```

### 5. Remove a Device

```bash
curl -X DELETE /api/devices/1 \
  -H "Authorization: Bearer $token"
```
