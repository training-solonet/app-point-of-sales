<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetJual extends Model
{
    use HasFactory;

    protected $table = 'det_jual';

    protected $fillable = [
        'jual_id',
        'barang_id',
        'qty',
        'harga_jual',
        'diskon',
        'harga_beli',
    ];

    public function jual()
    {
        return $this->belongsTo(Jual::class, 'jual_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
