<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Produk extends Model
{
    protected $fillable = ['nama_produk', 'kode_produk', 'kategori', 'satuan'];

    public function lokasis()
    {
        return $this->belongsToMany(Lokasi::class, 'produk_lokasi')->withPivot('stok')->withTimestamps();
    }
    // mutator agar nama_produk huruf kapital
    protected function namaProduk(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value)
        );
    }
}
