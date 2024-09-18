# app-point-of-sales

# Requirement

```bash
composer require mike42/escpos-php
composer require tymon/jwt-auth
```

Secret key for JWT

```bash
php artisan jwt:secret
```

# API Usage POST Order

Postman (recommend using raw body)

```json
{
    "customer_name": "Miss Agnes Pfeffer",
    "products": [
        {
            "barang_id": 1,
            "qty": 2
        },
        {
            "barang_id": 3,
            "qty": 1
        }
    ],
    "payment_method": "cash"
}
```

# API Usage POST if it new customer Order

```json
{
    "customer_name": "Justin Wijaya",
    "no_hp": "+6281234567890",
    "alamat": "Sebelah sana",
    "products": [
        {
            "barang_id": 1,
            "qty": 3
        },
        {
            "barang_id": 2,
            "qty": 2
        }
    ],
    "payment_method": "cash"
}
```
It wont affected if "customer_name" already existed.