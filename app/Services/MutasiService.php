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
    public function getMutasiAll()
    {
        return Mutasi::with(['produkLokasi.produk', 'produkLokasi.lokasi', 'user'])
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'tanggal' => $m->tanggal,
                    'jenis_mutasi' => $m->jenis_mutasi,
                    'jumlah' => $m->jumlah,
                    'keterangan' => $m->keterangan,
                    'produk' => $m->produkLokasi->produk->nama_produk ?? null,
                    'lokasi' => $m->produkLokasi->lokasi->nama_lokasi ?? null,
                    'user' => $m->user->name ?? null,
                ];
            });
    }
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
    public function updateMutasi(array $data, Mutasi $mutasi)
    {
        $request = (object) $data;

        // Ambil produk & lokasi dari mutasi lama
        $produkLokasi = DB::table('produk_lokasi')->where('id', $mutasi->produk_lokasi_id)->first();

        // Ambil pivot lama
        $produk = Produk::findOrFail($produkLokasi->produk_id);
        $pivot = $produk->lokasis()->where('lokasi_id', $produkLokasi->lokasi_id)->first();
        $stokSebelum = $pivot->pivot->stok;

        // Rollback stok lama
        $stokRollback = $mutasi->jenis_mutasi === 'masuk'
            ? $stokSebelum - $mutasi->jumlah
            : $stokSebelum + $mutasi->jumlah;

        // Hitung stok baru
        $stokBaru = $request->jenis_mutasi === 'masuk'
            ? $stokRollback + $request->jumlah
            : $stokRollback - $request->jumlah;

        if ($stokBaru < 0) {
            return response()->json(['message' => 'Stok tidak cukup untuk update mutasi keluar'], 400);
        }

        // Update pivot
        $produk->lokasis()->updateExistingPivot($produkLokasi->lokasi_id, ['stok' => $stokBaru]);

        // Update mutasi
        $mutasi->update([
            'tanggal' => Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d'),
            'jenis_mutasi' => $request->jenis_mutasi,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json($mutasi);
    }
    public function deleteMutasi(Mutasi $mutasi)
    {
        // Ambil produk & lokasi
        $produkLokasi = DB::table('produk_lokasi')->where('id', $mutasi->produk_lokasi_id)->first();
        $produk = Produk::findOrFail($produkLokasi->produk_id);
        $pivot = $produk->lokasis()->where('lokasi_id', $produkLokasi->lokasi_id)->first();

        $stokSekarang = $pivot->pivot->stok;

        // Rollback mutasi
        $stokSetelahHapus = $mutasi->jenis_mutasi === 'masuk'
            ? $stokSekarang - $mutasi->jumlah
            : $stokSekarang + $mutasi->jumlah;

        if ($stokSetelahHapus < 0) {
            return response()->json(['message' => 'Tidak bisa hapus mutasi karena menyebabkan stok negatif'], 400);
        }

        // Update pivot
        $produk->lokasis()->updateExistingPivot($produkLokasi->lokasi_id, ['stok' => $stokSetelahHapus]);

        // Hapus mutasi
        $mutasi->delete();

        return response()->json(['message' => 'Mutasi berhasil dihapus']);
    }
}
