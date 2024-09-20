#  Point of Sales App
Aplikasi Point of Sales (POS) yang dirancang untuk mempermudah transaksi penjualan. Aplikasi ini mendukung pengelolaan pelanggan, produk, dan metode pembayaran.



## Dashboard Menu (Example)
![screenshot](/resources/css/Screenshot%202024-09-18%20133432.png)


## Local Installation
```bash
1. git clone https://github.com/training-solonet/app-point-of-sales.git
2. cd app-point-of-sales
3. composer install
4. copy .env.example to .env
5. set up your database in .env
6. php artisan key:generate
  Enjoy Your App 🎉
```


### Requirement
Pastikan Anda telah menginstal beberapa dependensi berikut sebelum menjalankan aplikasi:

```bash
composer require mike42/escpos-php
composer require tymon/jwt-auth
```

### Secret key for JWT 🔑
```bash
php artisan jwt:secret
```

## 🔥API Usage POST Order

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

## 🔥API Usage POST if it new customer Order

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
