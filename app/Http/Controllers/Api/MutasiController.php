<?php

namespace App\Http\Controllers\Api;

use App\Models\Mutasi;
use App\Helpers\RestHttp;
use Illuminate\Http\Request;
use App\Services\MutasiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMutasiRequest;
use App\Http\Requests\Api\UpdateMutasiRequest;

class MutasiController extends Controller
{
    protected $mutasiService;
    public function __construct(MutasiService $mutasiService)
    {
        $this->mutasiService = $mutasiService;
    }
    public function getAllMutasi()
    {
        $mutasi = $this->mutasiService->getMutasiAll();
        return RestHttp::success($mutasi, 'Mutasi Berhasil Didapatkan!', 200);
    }
    public function tambahMutasi(StoreMutasiRequest $request)
    {
        try {
            $mutasi = $this->mutasiService->storeMutasi($request->validated());
            return RestHttp::success($mutasi, 'Mutasi Berhasil Ditambahkan!', 201);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
    public function editMutasi(UpdateMutasiRequest $request, Mutasi $mutasi)
    {
        try {
            $mutasi = $this->mutasiService->updateMutasi($request->validated(), $mutasi);
            return RestHttp::success($mutasi, 'Mutasi Berhasil Diupdate!', 200);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
    public function hapusMutasi(Mutasi $mutasi)
    {
        try {
            $mutasi = $this->mutasiService->deleteMutasi($mutasi);
            return RestHttp::success($mutasi, 'Mutasi Berhasil Diupdate!', 200);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
}
