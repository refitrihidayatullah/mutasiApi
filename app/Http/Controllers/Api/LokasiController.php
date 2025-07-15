<?php

namespace App\Http\Controllers\Api;

use App\Models\Lokasi;
use App\Helpers\RestHttp;
use Illuminate\Http\Request;
use App\Services\LokasiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreLokasiRequest;
use App\Http\Requests\Api\UpdateLokasiRequest;

class LokasiController extends Controller
{
    protected $lokasiService;
    public function __construct(LokasiService $lokasiService)
    {
        $this->lokasiService = $lokasiService;
    }
    public function getAllLokasi()
    {
        try {
            $lokasi = $this->lokasiService->getLokasiAll();
            return RestHttp::success($lokasi, 'Lokasi Berhasil Diambil!', 201);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
    public function tambahLokasi(StoreLokasiRequest $request)
    {
        try {
            $lokasi = $this->lokasiService->storeLokasi($request->validated());
            return RestHttp::success($lokasi, 'Lokasi Berhasil Ditambahkan!', 201);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
    public function editLokasi(UpdateLokasiRequest $request, $id)
    {
        try {
            $lokasi = $this->lokasiService->updateLokasi($id, $request->validated());
            return RestHttp::success($lokasi, 'Data Berhasil Diupdate', 200);
        } catch (\Exception $e) {
            return RestHttp::error($e->getMessage(), 404);
        }
    }
    public function hapusLokasi($id)
    {
        try {
            $lokasi = $this->lokasiService->deleteLokasi($id);
            return RestHttp::success($lokasi, 'Data Berhasil Dihapus', 200);
        } catch (\Exception $e) {
            return RestHttp::error($e->getMessage(), 404);
        }
    }
}
