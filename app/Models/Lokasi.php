<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Lokasi extends Model
{
    protected $fillable = ['kode_lokasi', 'nama_lokasi'];

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'produk_lokasi')->withPivot('stok')->withTimestamps();
    }
    protected function namaLokasi(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value)
        );
    }
}
