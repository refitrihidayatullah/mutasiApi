<?php

namespace App\Services;

use App\Models\User;
use App\Models\Mutasi;
use App\Models\Produk;

class HistoryService
{
    public function getHistoryProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $mutasi = Mutasi::with(['produkLokasi', 'user'])
            ->whereHas('produkLokasi', function ($query) use ($id) {
                $query->where('produk_id', $id);
            })
            ->orderby('tanggal', 'desc')
            ->get();
        $data = [
            "produk" => $produk,
            "mutasi" => $mutasi
        ];
        return $data;
    }
    public function getHistoryUser($id)
    {
        $user = User::findOrFail($id);
        $mutasi = Mutasi::with(['produkLokasi', 'user'])
            ->whereHas('produkLokasi', function ($query) use ($id) {
                $query->where('user_id', $id);
            })->orderby('tanggal', 'desc')->get();
        $data = [
            "user" => $user,
            "mutasi" => $mutasi
        ];
        return $data;
    }
}
