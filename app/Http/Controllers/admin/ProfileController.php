<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function me(){
        return Responses::success([
            'admin' => \Auth::user()
        ]);
    }

    public function update(){
        $data = request()->only('name', 'email', 'password', 'password_confirmation');
        $validator = \Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,'.\Auth::user()->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        auth()->user()->update($data);
        return Responses::success([], 200, __('site.Profile updated successfully'));
    }
}
