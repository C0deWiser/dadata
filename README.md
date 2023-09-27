# DaData

Laravel package.

Brings `DaData` data types.

For now supported search for taxpayers only.

Add to `config/services.php`:

```php
'dadata' => [
    'token' => env('DADATA_TOKEN'),
    'secret' => env('DADATA_SECRET'),
]
```
