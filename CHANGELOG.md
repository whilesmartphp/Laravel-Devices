## [1.1.0] - 2026-08-04
- Add endpoint to update a device by identifier (UUID) instead of database ID, e.g. for updating FCM tokens
- Register config defaults so `db_table_name` resolves at runtime without publishing the config
- Add `type` to the Device model fillable

## [1.0.1] - 2026-01-24
- Fix wrong provider name in composer.json
- Add support for multiple languages
- Add command to export openapi documentations
- Add Notifiable to the Device model.

## [1.0.0] - 2025-03-17
- Initial release
