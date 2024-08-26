<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal_harian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'keterangan',
        'nominal',
        'status',
    ]; 

    protected $table = 'jurnal_harian';
}
