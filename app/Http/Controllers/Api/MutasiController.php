<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RestHttp;
use Illuminate\Http\Request;
use App\Services\MutasiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMutasiRequest;

class MutasiController extends Controller
{
    protected $mutasiService;
    public function __construct(MutasiService $mutasiService)
    {
        $this->mutasiService = $mutasiService;
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
}
