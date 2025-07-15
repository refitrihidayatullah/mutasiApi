<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use App\Helpers\RestHttp;
use Illuminate\Http\Request;
use App\Services\ProdukService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProdukRequest;
use App\Http\Requests\Api\UpdateProdukRequest;

class ProdukController extends Controller
{
    protected $produkService;
    public function __construct(ProdukService $produkService)
    {
        $this->produkService = $produkService;
    }
    public function getAllProduk()
    {
        try {
            $produk = $this->produkService->getProdukAll();
            return RestHttp::success($produk, 'Produk Berhasil Diambil!', 201);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
    public function tambahProduk(StoreProdukRequest $request)
    {
        try {
            $produk = $this->produkService->storeProduk($request->validated());
            return RestHttp::success($produk, 'Produk Berhasil Ditambahkan!', 201);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
    public function editProduk(UpdateProdukRequest $request, $id)
    {
        try {
            $student = $this->produkService->updateProduk($id, $request->validated());
            return RestHttp::success($student, 'Data Berhasil Diupdate', 200);
        } catch (\Exception $e) {
            return RestHttp::error($e->getMessage(), 404);
        }
    }
    public function hapusProduk($id)
    {
        try {
            $student = $this->produkService->deleteProduk($id);
            return RestHttp::success($student, 'Data Berhasil Dihapus', 200);
        } catch (\Exception $e) {
            return RestHttp::error($e->getMessage(), 404);
        }
    }
}
