<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id',
        'tanggal_masuk',
        'barang_id',
        'harga_beli',
        'jual_id',
        'tanggal_keluar',
        'harga_jual',
    ];

    protected $table = 'stok';

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function detailPurchaseOrder()
    {
        return $this->belongsTo(Detail_purchase_order::class, 'kode_po', 'kode_po');
    }
}
