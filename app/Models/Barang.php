<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kode',
        'part_number',
        'nama',
        'id_kategori',
        'id_satuan',
        'stok',
        'harga_jual',
        'gambar',
    ];

    public function kategori()
    {
        return $this->BelongsTo(Kategori::class, 'id_kategori');
    }

    public function satuan()
    {
        return $this->BelongsTo(Satuan::class, 'id_satuan');
    }
}
