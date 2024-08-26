<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_order extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_po',
        'kode_distributor',
        'tgl',
        'attn',
        'total',
        'ppn',
        'ongkir',
        'keterangan',
        'pengguna',
        'status',
        'dp',
        'id_user',
    ];

    public function distributor()
    {
        return $this->BelongsTo(Distributor::class, 'kode_distributor', 'kode');
    }

    public function detail_purchase_order()
    {
        return $this->hasMany(Detail_purchase_order::class, 'kode_po');
    }


    protected $table = 'purchase_orders';
}
