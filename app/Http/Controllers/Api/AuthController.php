<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\RestHttp;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function getAllUser()
    {
        try {
            $user = $this->authService->getUserAll();
            return RestHttp::success($user, 'Users Berhasil Diambil!', 200);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
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
    public function loginUser(LoginUserRequest $request)
    {
        try {
            $token = $this->authService->loginUser($request->validated());

            return RestHttp::success($token, 'Login berhasil', 200);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
    public function editUser(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->authService->updateUser($id, $request->validated());
            return RestHttp::success($user, 'Update User berhasil', 200);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
    public function hapusUser(User $user)
    {
        try {
            $user = $this->authService->deleteUser($user);
            return RestHttp::success($user, 'Data berhasil Dihapus', 200);
        } catch (\Exception $e) {
            return RestHttp::error(
                $e->getMessage(),
                ['trace' => config('app.debug') ? $e->getTrace() : null],
                500
            );
        }
    }
}
