<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'attn',
        'telp',
        'keterangan',
        'bank',
        'nomer_rekening',
        'atas_nama',
    ]; 

    protected $table = 'distributor';
}
