<?php

namespace App\Services;

use App\Models\Lokasi;
use App\Helpers\GenerateCode;

class LokasiService
{
    public function getLokasiAll()
    {
        return Lokasi::all();
    }
    public function storeLokasi($request)
    {
        $request = (object) $request;
        $data = [
            "nama_lokasi" => $request->nama_lokasi,
            "kode_lokasi" => GenerateCode::generateKodeUnik($request->nama_lokasi, Lokasi::class, 'kode_lokasi')
        ];
        return Lokasi::create($data);
    }
    public function updateLokasi($id, $data)
    {
        $lokasi = Lokasi::where('id', $id)->first();
        if (empty($lokasi)) {
            throw new \Exception("Lokasi Tidak Ditemukan");
        }
        $lokasi->update($data);
        return $lokasi;
    }
    public function deleteLokasi($id)
    {
        $lokasi = Lokasi::where('id', $id)->first();
        if (empty($lokasi)) {
            throw new \Exception("Lokasi Tidak Ditemukan");
        }
        $lokasi->delete();
    }
}
