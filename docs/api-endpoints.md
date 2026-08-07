## API Endpoints

Routes are registered under the configured prefix (default `api`) with Sanctum authentication middleware.

### List Devices

```http
GET /api/devices
```

Returns all devices linked to the authenticated user.

**Response:**

```json
{
  "success": true,
  "message": "Devices retrieved.",
  "data": [...]
}
```

### Register Device

```http
POST /api/devices
```

**Body Parameters:**

| Parameter | Type | Required | Description |
|---|---|---|---|
| `token` | string | yes | FCM push notification token |
| `name` | string | no | Human-readable device name |
| `type` | enum | no | `web` or `mobile` (default: `mobile`) |
| `identifier` | string | no | Device identifier such as a UUID |
| `platform` | string | no | Platform name such as `Windows`, `iOS`, `Android` |

**Response:** `201 Created`

```json
{
  "success": true,
  "message": "Device created.",
  "data": {...}
}
```

### Update Device

```http
PUT /api/devices/{id}
```

Accepts the same fields as the store endpoint.

### Update Device by Identifier

```http
PUT /api/devices/identifier/{identifier}
```

Updates a device using its identifier string instead of database ID. For security, only the `token` field can be updated through this endpoint. Device name, type, identifier, and platform cannot change.

### Delete Device

```http
DELETE /api/devices/{id}
```

Removes a device from the database.
