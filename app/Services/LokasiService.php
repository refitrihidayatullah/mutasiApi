<?php

namespace App\Services;

use App\Models\Lokasi;

class LokasiService
{
    public function getLokasiAll()
    {
        return Lokasi::all();
    }
    public function storeLokasi($request)
    {
        return Lokasi::create($request);
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
