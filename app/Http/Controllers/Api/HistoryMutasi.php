<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Mutasi;
use App\Models\Produk;
use App\Helpers\RestHttp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\HistoryService;

class HistoryMutasi extends Controller
{
    protected $historyMutasi;
    public function __construct(HistoryService $historyMutasi)
    {
        $this->historyMutasi = $historyMutasi;
    }
    public function historyProduk($id)
    {
        $history = $this->historyMutasi->getHistoryProduk($id);
        return RestHttp::success($history, 'data berhasil didapatkan!', 200);
    }
    public function historyUser($id)
    {
        $history = $this->historyMutasi->getHistoryUser($id);
        return RestHttp::success($history, 'data berhasil didapatkan', 200);
    }
}
