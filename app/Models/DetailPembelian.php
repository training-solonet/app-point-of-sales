<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_invoice',
        'kode_barang',
        'part_number',
        'qty',
        'harga_satuan',
    ];

    protected $table = 'detail_pembelian';

    public function pembelian()
    {
        return $this->BelongsTo(Pembelian::class, 'no_invoice', 'no_invoice');
    }

    public function barang()
    {
        return $this->HasOne(Barang::class, 'kode', 'kode_barang');
    }
}
