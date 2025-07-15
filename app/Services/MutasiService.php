<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mutasi;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MutasiService
{
    public function storeMutasi(array $data)
    {
        $request = (object) $data;
        // Temukan pivot
        $produk = Produk::findOrFail($request->produk_id);
        $pivot = $produk->lokasis()->where('lokasi_id', $request->lokasi_id)->first();
        if (! $pivot) {
            // Buat relasi jika belum ada
            $produk->lokasis()->attach($request->lokasi_id, ['stok' => 0]);
            $pivot = $produk->lokasis()->where('lokasi_id', $request->lokasi_id)->first();
        }
        $currentStok = $pivot->pivot->stok;

        // Hitung stok baru
        $newStok = $request->jenis_mutasi === 'masuk'
            ? $currentStok + $request->jumlah
            : $currentStok - $request->jumlah;

        if ($newStok < 0) {
            return response()->json(['message' => 'Stok tidak cukup untuk mutasi keluar'], 400);
        }

        // Update stok di pivot
        $produk->lokasis()->updateExistingPivot($request->lokasi_id, ['stok' => $newStok]);

        // Simpan mutasi
        $mutasi = Mutasi::create([
            'user_id' => Auth::id(),
            'produk_lokasi_id' => DB::table('produk_lokasi')
                ->where('produk_id', $request->produk_id)
                ->where('lokasi_id', $request->lokasi_id)
                ->value('id'),
            'tanggal' => Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d'),
            'jenis_mutasi' => $request->jenis_mutasi,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json($mutasi);
    }
}
