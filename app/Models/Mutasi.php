<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $fillable = ['user_id', 'produk_lokasi_id', 'tanggal', 'jenis_mutasi', 'jumlah', 'keterangan'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produkLokasi()
    {
        return $this->belongsTo(ProdukLokasi::class);
    }
}
