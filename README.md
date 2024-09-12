# app-point-of-sales

# API Usage POST

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

# API Usage POST if it new customer

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