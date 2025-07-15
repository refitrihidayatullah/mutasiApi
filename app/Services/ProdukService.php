<?php

namespace App\Services;

use App\Helpers\GenerateCode;
use App\Models\Produk;

class ProdukService
{
    public function getProdukAll()
    {
        return Produk::all();
    }
    public function storeProduk($request)
    {
        $request = (object) $request;
        $data = [
            "nama_produk" => $request->nama_produk,
            "kode_produk" => GenerateCode::generateKodeUnik($request->nama_produk, Produk::class, 'kode_produk'),
            "kategori" => $request->kategori,
            "satuan" => $request->satuan
        ];
        return Produk::create($data);
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
