<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RestHttp;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterUserRequest;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function registerUser(RegisterUserRequest $request)
    {
        try {
            $token = $this->authService->storeUser($request->validated());

            return RestHttp::success($token, 'Register berhasil', 201);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
}
