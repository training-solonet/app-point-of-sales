<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_purchase_order extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_po',
        'kode_barang',
        'part_number',
        'qty',
        'harga_satuan',
    ]; 

    protected $table = 'detail_purchase_orders';

    public function purchase_order()
    {
        return $this->BelongsTo(Purchase_order::class,'kode_po','kode_po');
    }

    public function barang()
    {
        return $this->HasOne(Barang::class,'kode','kode_barang');
    }
}
