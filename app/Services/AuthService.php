<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
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
}
