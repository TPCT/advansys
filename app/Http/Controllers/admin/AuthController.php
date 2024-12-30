<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class AuthController extends Controller
{
    public function login(){
        $data = request()->only(['email', 'password']);
        $validator = \Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        $token = \Auth::attempt($data);
        if (!$token)
            return Responses::error([], 422, __("errors.Invalid Username or Password"));
        return Responses::success([
            'admin' => \Auth::user(),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout(){
        auth()->logout();
        return Responses::success([], 200, __("site.Logged out successfully"));
    }
}
