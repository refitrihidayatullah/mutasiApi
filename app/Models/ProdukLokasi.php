<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukLokasi extends Model
{
    protected $fillable = ['produk_id', 'lokasi_id', 'stok'];
    protected $table = 'produk_lokasi';
    protected $primaryKey = 'id';
}
