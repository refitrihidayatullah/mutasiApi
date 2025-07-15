<?php

namespace App\Services;

use App\Models\Produk;

class ProdukService
{
    public function getProdukAll()
    {
        return Produk::all();
    }
    public function storeProduk($request)
    {
        return Produk::create($request);
    }
    public function updateProduk($id, array $data)
    {
        $produk = Produk::where('id', $id)->first();
        if (empty($produk)) {
            throw new \Exception("Produk Tidak Ditemukan");
        }
        $produk->update($data);
        return $produk;
    }
    public function deleteProduk($id)
    {
        $produk = Produk::where('id', $id)->first();
        if (empty($produk)) {
            throw new \Exception("Produk Tidak Ditemukan");
        }
        $produk->delete();
    }
}
