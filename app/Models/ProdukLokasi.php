<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukLokasi extends Model
{
    protected $fillable = ['produk_id', 'lokasi_id', 'stok'];
    protected $table = 'produk_lokasi';
    protected $primaryKey = 'id';

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function mutasis()
    {
        return $this->hasMany(Mutasi::class);
    }
}
