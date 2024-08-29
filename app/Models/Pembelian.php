<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $fillable = [
        'no_invoice',
        'kode_po',
        'tgl_beli',
        'tgl_tempo',
        'ppn',
        'ongkir',
        'diskon',
        'biaya_lain',
        'total',
        'status',
        'keterangan',
        'pengguna',
        'barang_masuk',
        'can_delete',
        'id_transaksi',
    ];

    public function purchase_orders()
    {
        return $this->BelongsTo(Purchase_order::class, 'kode_po', 'kode_po');
    }

    public function distributor()
    {
        return $this->BelongsTo(Distributor::class, 'kode_distributor', 'kode_distributor');
    }

    public function detail_pembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'no_invoice', 'no_invoice');
    }
}
