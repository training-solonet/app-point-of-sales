<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jual extends Model
{
    use HasFactory;

    protected $table = 'jual';

    protected $fillable = [
        'no_faktur',
        'customer_id',
        'tanggal',
        'total',
        'bayar',
        'diskon',
        'ppn',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
