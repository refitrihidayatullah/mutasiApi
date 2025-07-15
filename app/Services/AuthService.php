<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function getUserAll()
    {
        return User::all();
    }
    public function storeUser($request)
    {
        $data =
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password'])
            ];
        $register = User::create($data);
        $token = $register->createToken('API Token')->plainTextToken;
        return $token;
    }
    public function loginUser($request)
    {
        $user = User::where('email', $request['email'])->first();
        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }
        $token = $user->createToken('API Token')->plainTextToken;
        return $token;
    }
    public function updateUser($id, $request)
    {
        $user = User::findOrFail($id);

        if (!empty($request['password'])) {
            $request['password'] = bcrypt($request['password']);
        } else {
            unset($request['password']); // jangan update password jika kosong
        }

        $user->update($request);

        return $user;
    }
    public function deleteUser($user)
    {
        return $user->delete();
    }
}
